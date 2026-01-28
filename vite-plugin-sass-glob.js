import path from 'path';
import fs from 'fs';
import { globSync } from 'glob';
import { minimatch } from "minimatch";

export default function sassGlob(options = {}) {
  // Regular expressions to match against.
  const FILE_REGEX = /\.s([ac])ss(\?direct)?$/;
  const USE_REGEX = /^[ \t]*@use\s+["']([^"']*\*[^"']*)["']([ \t]+(?:as|with)[^;]*)?;?[ \t]*$/gm;

  // Path to the directory of the file being processed.
  let filePath = '';

  // Name of the file being processed.
  let fileName = '';

  function isSassOrScss(filename) {
    return (!fs.statSync(filename).isDirectory() && path.extname(filename).match(/\.sass|\.scss/i));
  }

  const transform = (src) => {
    // Determine if this is Sass (vs SCSS) based on file extension.
    const isSass = path.extname(fileName).match(/\.sass/i);

    // Store base locations.
    const searchBases = [filePath];

    // Ignore paths.
    const ignorePaths = options.ignorePaths || [];

    // Get each line of src.
    let contentLinesCount = src.split('\n').length;

    let result;

    // Loop through each line
    for (let i = 0; i < contentLinesCount; i++) {
      // Find any glob import patterns on the line
      result = [...src.matchAll(USE_REGEX)];

      if (result.length) {
        const [importRule, globPattern, suffix = ''] = result[0];

        let files = [];
        let basePath = '';

        for (let i = 0; i < searchBases.length; i++) {
          basePath = searchBases[i];

          files = globSync(path.join(basePath, globPattern), {
            cwd: './',
            windowsPathsNoEscape: true,
          }).sort((a, b) => a.localeCompare(b, 'en'));

          const globPatternWithoutWildcard = globPattern.split('*')[0];
          if (globPatternWithoutWildcard.length) {
            const directoryExists = fs.existsSync(path.join(basePath, globPatternWithoutWildcard));
            if (!directoryExists) {
              console.warn(`Sass Glob Use: Directories don't exist for the glob pattern "${globPattern}"`);
            }
          }

          if (files.length > 0) break;
        }

        let imports = [];

        files.forEach((filename) => {
          if (isSassOrScss(filename)) {
            filename = path.relative(basePath, filename).replace(/\\/g, '/').replace(/^\//, '');

            if (!ignorePaths.some((ignorePath) => minimatch(filename, ignorePath))) {
              imports.push(`@use "${filename}"${suffix}` + (isSass ? '' : ';'));
            }
          }
        });

        const replaceString = imports.join('\n');
        src = src.replace(importRule, replaceString);
      }
    }

    // Return the transformed source
    return src;
  }

  return {
    name: 'sass-glob',
    enforce: 'pre',

    transform(src, id) {
      let result = {
        code: src,
        map: null, // Provide source map if available.
      }

      if (FILE_REGEX.test(id)) {
        fileName = path.basename(id);
        filePath = path.dirname(id);

        result.code = transform(src);
      }

      return result;
    },
  };
}
