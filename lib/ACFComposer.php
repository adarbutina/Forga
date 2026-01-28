<?php

namespace Flynt;

use Exception;

class ACFComposer
{
    /**
     * Registers a local field group in Advanced Custom Fields based on a config array.
     *
     * Included fields, subfields, etc. can either contain another array defining them, or a string that stands for a WordPress filter.
     * This filter will be applied and its result used as the field, subfield, etc.
     *
     * @param array $config Configuration array for the local field group.
     *
     * @return bool Was the field group added or not.
     *
     * @throws Exception
     */
    public static function registerFieldGroup(array $config): bool
    {
        $fieldGroup = self::forFieldGroup($config);
        return acf_add_local_field_group($fieldGroup);
    }

    /**
     * Validates and resolves a configuration for a local field group.
     *
     * @param array $config Configuration array for the local field group.
     * @return array Resolved field group configuration.
     * @throws Exception
     */
    public static function forFieldGroup(array $config): array
    {
        $output = self::validateConfig($config, ['name', 'title', 'fields', 'location']);
        $keySuffix = $output['name'];
        $output['key'] = "group_$keySuffix";
        $output['fields'] = array_reduce($config['fields'], function ($carry, $fieldConfig) use ($keySuffix) {
            $fields = self::forField($fieldConfig, [$keySuffix]);
            self::pushSingleOrMultiple($carry, $fields);
            return $carry;
        }, []);
        $output['location'] = array_map([self::class, 'mapLocation'], $output['location']);
        return $output;
    }

    /**
     * Validates a location the configuration for a field group location.
     *
     * @param array $config Configuration array for a location of a field group.
     * @return array Valid config.
     * @throws Exception
     */
    public static function forLocation(array $config): array
    {
        return self::validateConfig($config, ['param', 'operator', 'value']);
    }

    /**
     * Validates and resolves a field configuration.
     *
     * @param array|string $config Configuration array for any kind of field.
     * @param array $parentKeys Previously used keys of all parent fields.
     *
     * @return array Resolved config for a field.
     *
     * @throws Exception
     */
    public static function forField(array|string $config, array $parentKeys = []): array
    {
        return self::forEntity($config, ['name', 'label', 'type'], $parentKeys);
    }

    /**
     * Validates and resolves a layout configuration of a flexible content field.
     *
     * @param array|string $config Configuration array for the local field group.
     * @param array $parentKeys Previously used keys of all parent fields.
     *
     * @return array Resolved config for a layout of a flexible content field.
     *
     * @throws Exception
     */
    public static function forLayout(array|string $config, array $parentKeys = []): array
    {
        return self::forEntity($config, ['name', 'label'], $parentKeys);
    }

    /**
     * Validates and resolves configuration for a field, subfield, or layout. Applies prefix through filter arguments.
     *
     * @param array|string $config Configuration array for the nested entity.
     * @param array $requiredAttributes Required attributes.
     * @param array $parentKeys Previously used keys of all parent fields.
     * @param string|null $prefix Optional prefix for named field based on filter arguments.
     *
     * @return array Resolved config.
     *
     * @throws Exception
     */
    protected static function forEntity(array|string $config, array $requiredAttributes, array $parentKeys = [], string $prefix = null): array
    {
        if (is_string($config)) {
            $filterName = $config;
            $filterParts = explode('#', $filterName);
            if (isset($filterParts[1])) {
                $prefix = $filterParts[1];
                $config = apply_filters($filterParts[0], null, $prefix);
                if (!self::isAssoc($config)) {
                    $config = array_map(function ($singleConfig) use ($prefix) {
                        $singleConfig['name'] = $prefix . '_' . $singleConfig['name'];
                        return $singleConfig;
                    }, $config);
                } else {
                    $config['name'] = $prefix . '_' . $config['name'];
                }
            } else {
                $config = apply_filters($filterName, null);
            }


            if (is_null($config)) {
                trigger_error("ACFComposer: Filter $filterName does not exist!", E_USER_WARNING);
                return [];
            }
        }
        if (!self::isAssoc($config)) {
            return array_map(function ($singleConfig) use ($requiredAttributes, $parentKeys, $prefix) {
                return self::forEntity($singleConfig, $requiredAttributes, $parentKeys, $prefix);
            }, $config);
        }

        $output = self::validateConfig($config, $requiredAttributes);

        $parentKeysIncludingPrefix = isset($prefix) ? array_merge($parentKeys, [$prefix]) : $parentKeys;
        $output = self::forConditionalLogic($output, $parentKeysIncludingPrefix);

        $parentKeys[] = $output['name'];

        $keySuffix = implode('_', $parentKeys);
        $output['key'] = "field_$keySuffix";

        $output = apply_filters('ACFComposer/resolveEntity', $output);
        $output = apply_filters("ACFComposer/resolveEntity?name={$output['name']}", $output);
        $output = apply_filters("ACFComposer/resolveEntity?key={$output['key']}", $output);
        return self::forNestedEntities($output, $parentKeys);
    }

    /**
     * Validates and resolves configuration for subfields and layouts.
     *
     * @param array $config Configuration array for the nested entity.
     * @param array $parentKeys Previously used keys of all parent fields.
     *
     * @return array Resolved config.
     *
     * @throws Exception
     */
    protected static function forNestedEntities(array $config, array $parentKeys): array
    {
        if (array_key_exists('sub_fields', $config)) {
            $config['sub_fields'] = array_reduce($config['sub_fields'], function ($output, $subField) use ($parentKeys) {
                $fields = self::forField($subField, $parentKeys);
                if (!self::isAssoc($fields)) {
                    foreach ($fields as $field) {
                        $output[] = $field;
                    }
                } else {
                    $output[] = $fields;
                }
                return $output;
            }, []);
        }
        if (array_key_exists('layouts', $config)) {
            $config['layouts'] = array_reduce($config['layouts'], function ($output, $layout) use ($parentKeys) {
                $subLayouts = self::forLayout($layout, $parentKeys);
                if (!self::isAssoc($subLayouts)) {
                    foreach ($subLayouts as $subLayout) {
                        $output[] = $subLayout;
                    }
                } else {
                    $output[] = $subLayouts;
                }
                return $output;
            }, []);
        }
        return $config;
    }

    /**
     * Validates a configuration array based on given required attributes.
     *
     * Usually the field key has to be provided for conditional logic to work. Since all keys are generated automatically by this plugin,
     * you can instead provide a 'relative path' to a field by its name.
     *
     * @param array $config Configuration array.
     * @param array $requiredAttributes Required Attributes.
     *
     * @return array Given $config.
     *
     * @throws Exception if a required attribute is not present.
     * @throws Exception if the `key` attribute is not present.
     */
    protected static function validateConfig(array $config, array $requiredAttributes = []): array
    {
        array_walk($requiredAttributes, function ($key) use ($config) {
            if (!array_key_exists($key, $config)) {
                throw new Exception("Field config needs to contain a \'$key\' property.");
            }
        });
        if (array_key_exists('key', $config)) {
            throw new Exception('Field config must not contain a \'key\' property.');
        }
        return $config;
    }

    /**
     * Maps location configurations to their resolved config arrays.
     *
     * @param array $locationArray All locations for a field group.
     *
     * @return array Resolved locations array.
     */
    protected static function mapLocation(array $locationArray): array
    {
        return array_map([self::class, 'forLocation'], $locationArray);
    }

    /**
     * Resolves a field's conditional logic attribute.
     *
     * Usually the field key has to be provided for conditional logic to work. Since all keys are generated automatically by this plugin,
     * you can instead provide a 'relative path' to a field by its name.
     *
     * @param array $config Configuration array for the conditional logic attribute.
     * @param array $parentKeys Previously used keys of all parent fields.
     *
     * @return array Resolved conditional logic attribute.
     */
    protected static function forConditionalLogic(array $config, array $parentKeys): array
    {
        if (array_key_exists('conditional_logic', $config)) {
            $config['conditional_logic'] = array_map(function ($conditionGroup) use ($parentKeys) {
                return array_map(function ($condition) use ($parentKeys) {
                    if (array_key_exists('fieldPath', $condition)) {
                        $conditionalField = $condition['fieldPath'];
                        while (str_starts_with($conditionalField, '../')) {
                            $conditionalField = substr($conditionalField, 3);
                            array_pop($parentKeys);
                        }
                        $parentKeys[] = $conditionalField;
                        $keySuffix = implode('_', $parentKeys);
                        $condition['field'] = "field_$keySuffix";
                        unset($condition['fieldPath']);
                    }
                    return $condition;
                }, $conditionGroup);
            }, $config['conditional_logic']);
        }
        return $config;
    }

    /**
     * Checks whether a given array is associative.
     *
     * @param array $arr Array to check.
     *
     * @return bool
     */
    protected static function isAssoc(array $arr): bool
    {
        if (array() === $arr) {
            return false;
        }
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    /**
     * Adds a single or multiple elements to an array.
     *
     * @param array &$carry Array to add to.
     * @param array $fields Single or multiple associative arrays to add to $arr.
     *
     * @return array
     */
    protected static function pushSingleOrMultiple(array &$carry, array $fields): array
    {
        if (!self::isAssoc($fields)) {
            foreach ($fields as $field) {
                self::pushSingleOrMultiple($carry, $field);
            }
        } else {
            $carry[] = $fields;
        }
        return $carry;
    }
}
