## Version 8.0 beta

This new major release is quite a big overhaul bringing both new features and
some backwards incompatible changes. However, chances are that the majority of
users won't be affected by the latter: the basic scenario described in the
README is left intact.

Here's what did change in an incompatible way:

- We're now prefixing all classes located in [CSS classes reference][cr] with
  `hljs-`, by default, because some class names would collide with other
  people's stylesheets. If you were using an older version, you might still want
  the previous behavior, but still want to upgrade. To suppress this new
  behavior, you would initialize like so:

  ```html
  <script type="text/javascript">
    hljs.configure({classPrefix: ''});
    hljs.initHighlightingOnLoad();
  </script>
  ```

- `tabReplace` and `useBR` that were used in different places are also unified
  into the global options object and are to be set using `configure(options)`.
  This function is documented in our [API docs][]. Also note that these
  parameters are gone from `highlightBlock` and `fixMarkup` which are now also
  rely on `configure`.

- We removed public-facing (though undocumented) object `hljs.LANGUAGES` which
  was used to register languages with the library in favor of two new methods:
  `registerLanguage` and `getLanguage`. Both are documented in our [API docs][].

- Result returned from `highlight` and `highlightAuto` no longer contains two
  separate attributes contributing to relevance score, `relevance` and
  `keyword_count`. They are now unified in `relevance`.

Another technically compatible change that nonetheless might need attention:

- The structure of the NPM package was refactored, so if you had installed it
  locally, you'll have to update your paths. The usual `require('highlight.js')`
  works as before. This is contributed by [Dmitry Smolin][].

New features:

- Languages now can be recognized by multiple names like "js" for JavaScript or
  "html" for, well, HTML (which earlier insisted on calling it "xml"). These
  aliases can be specified in the class attribute of the code container in your
  HTML as well as in various API calls. For now there are only a few very common
  aliases but we'll expand it in the future. All of them are listed in the
  [class reference][].

- Language detection can now be restricted to a subset of languages relevant in
  a given context — a web page or even a single highlighting call. This is
  especially useful for node.js build that includes all the known languages.
  Another example is a StackOverflow-style site where users specify languages
  as tags rather than in the markdown-formatted code snippets. This is
  documented in the [API reference][] (see methods `highlightAuto` and
  `configure`).

- Language definition syntax streamlined with [variants][] and
  [beg