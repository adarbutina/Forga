export default function (el) {
    jQuery(document.body).on('found_variation', updateComponent);

    function updateComponent(event, variation) {
      jQuery(el).replaceWith(variation.BlockProductPrice);
    }

    return () => {
      jQuery(document.body).off('found_variation', updateComponent);
    }
}
