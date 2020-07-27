CKEditor 4 Changelog
====================

## CKEditor 4.11.2

Fixed Issues:

* [#2403](https://github.com/ckeditor/ckeditor-dev/issues/2403): Fixed: Styling inline editor initialized inside a table with the [Table Selection](https://ckeditor.com/cke4/addon/tableselection) plugin is causing style leaks.
* [#2514](https://github.com/ckeditor/ckeditor-dev/issues/2403): Fixed: Pasting table data into inline editor initialized inside a table with the [Table Selection](https://ckeditor.com/cke4/addon/tableselection) plugin inserts pasted content into the wrapping table.
* [#2451](https://github.com/ckeditor/ckeditor-dev/issues/2451): Fixed: The [Remove Format](https://ckeditor.com/cke4/addon/removeformat) plugin changes selection.
* [#2546](https://github.com/ckeditor/ckeditor-dev/issues/2546): Fixed: The separator in the toolbar moves when buttons are focused.
* [#2506](https://github.com/ckeditor/ckeditor-dev/issues/2506): Fixed: [Enhanced Image](https://ckeditor.com/cke4/addon/image2) throws a type error when an empty `<figure>` tag with an `image` class is upcasted.
* [#2650](https://github.com/ckeditor/ckeditor-dev/issues/2650): Fixed: [Table](https://ckeditor.com/cke4/addon/table) dialog validator fails when the `getValue()`function is defined in the global scope.
* [#2690](https://github.com/ckeditor/ckeditor-dev/issues/2690): Fixed: Decimal characters are removed from the inside of numbered lists when pasting content using the [Paste from Word](https://ckeditor.com/cke4/addon/pastefromword) plugin.
* [#2205](https://github.com/ckeditor/ckeditor-dev/issues/2205): Fixed: It is not possible to add new list items under an item containing a block element.
* [#2411](https://github.com/ckeditor/ckeditor-dev/issues/2411), [#2438](https://github.com/ckeditor/ckeditor-dev/issues/2438) Fixed: Apply numbered list option throws a console error for a specific markup.
* [#2430](https://github.com/ckeditor/ckeditor-dev/issues/2430) Fixed: [Color Button](https://ckeditor.com/cke4/addon/colorbutton) and [List Block](https://ckeditor.com/cke4/addon/listblock) items are draggable.

Other Changes:

* Updated the [WebSpellChecker](https://ckeditor.com/cke4/addon/wsc) (WSC) plugin:
	* [#52](https://github.com/WebSpellChecker/ckeditor-plugin-wsc/issues/52) Fixed: Clicking "Finish Checking" without a prior action would hang the Spell Checking dialog.
* [#2603](https://github.com/ckeditor/ckeditor-dev/issues/2603): Corrected the GPL license entry in the `package.json` file.

## CKEditor 4.11.1

Fixed Issues:

* [#2571](https://github.com/ckeditor/ckeditor-dev/issues/2571): Fixed: Clicking the categories in the [Emoji](https://ckeditor.com/cke4/addon/emoji) dropdown panel scrolls the entire page.

## CKEditor 4.11

**Security Updates:**

* Fixed XSS vulnerability in the HTML parser reported by [maxarr](https://hackerone.com/maxarr).

	Issue summary: It was possible to execute XSS inside CKEditor after persuading the victim to: (i) switch CKEditor to source mode, then (ii) paste a specially crafted HTML code, prepared by the attacker, into the opened CKEditor source area, and (iii) switch back to WYSIWYG mode.

**An upgrade is highly recommended!**

New Features:

* [#2062](https://github.com/ckeditor/ckeditor-dev/pull/2062): Added the emoji dropdown that allows the user to choose the emoji from the toolbar and search for them using keywords.
* [#2154](https://github.com/ckeditor/ckeditor-dev/issues/2154): The [Link](https://ckeditor.com/cke4/addon/link) plugin now supports phone number links.
* [#1815](https://github.com/ckeditor/ckeditor-dev/issues/1815): The [Auto Link](https://ckeditor.com/cke4/addon/autolink) plugin supports typing link completion.
* [#2478](https://github.com/ckeditor/ckeditor-dev/issues/2478): [Link](https://ckeditor.com/cke4/addon/link) can be inserted using the <kbd>Ctrl</kbd>/<kbd>Cmd</kbd> + <kbd>K</kbd> keystroke.
* [#651](https://github.com/ckeditor/ckeditor-dev/issues/651): Text pasted using the [Paste from Word](https://ckeditor.com/cke4/addon/pastefromword) plugin preserves indentation in paragraphs.
* [#2248](https://github.com/ckeditor/ckeditor-dev/issues/2248): Added support for justification in the [BBCode](https://ckeditor.com/cke4/addon/bbcode) plugin. Thanks to [Matěj Kmínek](https://github.com/KminekMatej)!
* [#706](https://github.com/ckeditor/ckeditor-dev/issues/706): Added a different cursor style when selecting cells for the [Table Selection](https://ckeditor.com/cke4/addon/tableselection) plugin.
* [#2072](https://github.com/ckeditor/ckeditor-dev/issues/2072): The [UI Button](https://ckeditor.com/cke4/addon/button) plugin supports custom `aria-haspopup` property values. The [Menu Button](https://ckeditor.com/cke4/addon/menubutton) `aria-haspopup` value is now `menu`, the [Panel Button](https://ckeditor.com/cke4/addon/panelbutton) and [Rich Combo](https://ckeditor.com/cke4/addon/richcombo) `aria-haspopup` value is now `listbox`.
* [#1176](https://github.com/ckeditor/ckeditor-dev/pull/1176): The [Balloon Panel](https://ckeditor.com/cke4/addon/balloonpanel) can now be attached to a selection instead of an element.
* [#2202](https://github.com/ckeditor/ckeditor-dev/issues/2202): Added the `contextmenu_contentsCss` configuration option to allow adding custom CSS to the [Context Menu](https://ckeditor.com/cke4/addon/contextmenu).

Fixed Issues:

* [#1477](https://github.com/ckeditor/ckeditor-dev/issues/1477): Fixed: On destroy, [Balloon Toolbar](https://ckeditor.com/cke4/addon/balloontoolbar) does not destroy its content.
* [#2394](https://github.com/ckeditor/ckeditor-dev/issues/2394): Fixed: [Emoji](https://ckeditor.com/cke4/addon/emoji) dropdown does not show up with repeated symbols in a single line.
* [#1181](https://github.com/ckeditor/ckeditor-dev/issues/1181): [Chrome] Fixed: Opening the context menu in a read-only editor results in an error.
* [#2276](https://github.com/ckeditor/ckeditor-dev/issues/2276): [iOS] Fixed: [Button](https://ckeditor.com/cke4/addon/button) state does not refresh properly.
* [#1489](https://github.com/ckeditor/ckeditor-dev/issues/1489): Fixed: Table contents can be removed in read-only mode when the [Table Selection](https://ckeditor.com/cke4/addon/tableselection) plugin is used.
* [#1264](https://github.com/ckeditor/ckeditor-dev/issues/1264) Fixed: Right-click does not clear the selection created with the [Table Selection](https://ckeditor.com/cke4/addon/tableselection) plugin.
* [#586](https://github.com/ckeditor/ckeditor-dev/issues/586) Fixed: The `required` attribute is not correctly recognized by the [Form Elements](https://ckeditor.com/cke4/addon/forms) plugin dialog. Thanks to [Roli Züger](https://github.com/rzueger)!
* [#2380](https://github.com/ckeditor/ckeditor-dev/issues/2380) Fixed: Styling HTML comments in a top-level element results in extra paragraphs.
* [#2294](https://github.com/ckeditor/ckeditor-dev/issues/2294) Fixed: Pasting content from Microsoft Outlook and then bolding it results in an error.
* [#2035](https://github.com/ckeditor/ckeditor-dev/issues/2035) [Edge] Fixed: `Permission denied` is thrown when opening a [Panel](https://ckeditor.com/cke4/addon/panel) instance.
* [#965](https://github.com/ckeditor/ckeditor-dev/issues/965) Fixed: The [`config.forceSimpleAmpersand`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html#cfg-forceSimpleAmpersand) option does not work. Thanks to [Alex Maris](https://github.com/alexmaris)!
* [#2448](https://github.com/ckeditor/ckeditor-dev/issues/2448): Fixed: The [`Escape HTML Entities`] plugin with custom [additional entities](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html#cfg-entities_additional) configuration breaks HTML escaping.
* [#898](https://github.com/ckeditor/ckeditor-dev/issues/898): Fixed: [Enhanced Image](https://ckeditor.com/cke4/addon/image2) long alternative text protrudes into the editor when the image is selected.
* [#1113](https://github.com/ckeditor/ckeditor-dev/issues/1113): [Firefox] Fixed: Nested contenteditable elements path is not updated on focus with the [Div Editing Area](https://ckeditor.com/cke4/addon/divarea) plugin.
* [#1682](https://github.com/ckeditor/ckeditor-dev/issues/1682) Fixed: Hovering the [Balloon Toolbar](https://ckeditor.com/cke4/addon/balloontoolbar) panel changes its size, causing flickering.
* [#421](https://github.com/ckeditor/ckeditor-dev/issues/421) Fixed: Expandable [Button](https://ckeditor.com/cke4/addon/button) puts the `(Selected)` text at the end of the label when clicked.
* [#1454](https://github.com/ckeditor/ckeditor-dev/issues/1454): Fixed: The [`onAbort`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_fileTools_uploadWidgetDefinition.html#property-onAbort) method of the [Upload Widget](https://ckeditor.com/cke4/addon/uploadwidget) is not called when the loader is aborted.
* [#1451](https://github.com/ckeditor/ckeditor-dev/issues/1451): Fixed: The context menu is incorrectly positioned when opened with <kbd>Shift</kbd>+<kbd>F10</kbd>.
* [#1722](https://github.com/ckeditor/ckeditor-dev/issues/1722): [`CKEDITOR.filter.instances`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_filter.html#static-property-instances) is causing memory leaks.
* [#2491](https://github.com/ckeditor/ckeditor-dev/issues/2491): Fixed: The [Mentions](https://ckeditor.com/cke4/addon/mentions) plugin is not matching diacritic characters.
* [#2519](https://github.com/ckeditor/ckeditor-dev/issues/2519): Fixed: The [Accessibility Help](https://ckeditor.com/cke4/addon/a11yhelp) dialog should display all available keystrokes for a single command.

API Changes:

* [#2453](https://github.com/ckeditor/ckeditor-dev/issues/2453): The [`CKEDITOR.ui.panel.block.getItems`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_ui_panel_block.html#method-getItems) method now also returns `input` elements in addition to links.
* [#2224](https://github.com/ckeditor/ckeditor-dev/issues/2224):  The [`CKEDITOR.tools.convertToPx`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_tools.html#method-convertToPx) function now converts negative values.
* [#2253](https://github.com/ckeditor/ckeditor-dev/issues/2253): The widget definition [`insert`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_plugins_widget_definition.html#property-insert) method now passes `editor` and `commandData`. Thanks to [marcparmet](https://github.com/marcparmet)!
* [#2045](https://github.com/ckeditor/ckeditor-dev/issues/2045): Extracted [`tools.eventsBuffer`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_tools.html#method-eventsBuffer) and [`tools.throttle`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_tools.html#method-throttle) functions logic into a separate namespace.
	* [`tools.eventsBuffer`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_tools.html#method-eventsBuffer) was extracted into [`tools.buffers.event`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_tools_buffers_event.html),
	* [`tools.throttle`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_tools.html#method-throttle) was extracted into [`tools.buffers.throttle`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_tools_buffers_throttle.html).
* [#2466](https://github.com/ckeditor/ckeditor-dev/issues/2466):  The [`CKEDITOR.filter`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_tools.html#method-constructor) constructor accepts an additional `rules` parameter allowing to bind the editor and filter together.
* [#2493](https://github.com/ckeditor/ckeditor-dev/issues/2493):  The [`editor.getCommandKeystroke`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_editor.html#method-getCommandKeystroke) method accepts an additional `all` parameter allowing to retrieve an array of all command keystrokes.
* [#2483](https://github.com/ckeditor/ckeditor-dev/issues/2483): Button's DOM element created with the [`hasArrow`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_ui.html#method-addButton) definition option can by identified by the `.cke_button_expandable` CSS class.

Other Changes:

* [#1713](https://github.com/ckeditor/ckeditor-dev/issues/1713): Removed the redundant `lang.title` entry from the [Clipboard](https://ckeditor.com/cke4/addon/clipboard) plugin.

## CKEditor 4.10.1

Fixed Issues:

* [#2114](https://github.com/ckeditor/ckeditor-dev/issues/2114): Fixed: [Autocomplete](https://ckeditor.com/cke4/addon/autocomplete) cannot be initialized before [`instanceReady`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_editor.html#event-instanceReady).
* [#2107](https://github.com/ckeditor/ckeditor-dev/issues/2107): Fixed: Holding and releasing the mouse button is not inserting an [autocomplete](https://ckeditor.com/cke4/addon/autocomplete) suggestion.
* [#2167](https://github.com/ckeditor/ckeditor-dev/issues/2167): Fixed: Matching in [Emoji](https://ckeditor.com/cke4/addon/emoji) plugin is not case insensitive.
* [#2195](https://github.com/ckeditor/ckeditor-dev/issues/2195): Fixed: [Emoji](https://ckeditor.com/cke4/addon/emoji) shows the suggestion box when the colon is preceded with other characters than white space.
* [#2169](https://github.com/ckeditor/ckeditor-dev/issues/2169): [Edge] Fixed: Error thrown when pasting into the editor.
* [#1084](https://github.com/ckeditor/ckeditor-dev/issues/1084) Fixed: Using the "Automatic" option with [Color Button](https://ckeditor.com/cke4/addon/colorbutton) on a text with the color already defined sets an invalid color value.
* [#2271](https://github.com/ckeditor/ckeditor-dev/issues/2271): Fixed: Custom color name not used as a label in the [Color Button](https://ckeditor.com/cke4/addon/image2) plugin. Thanks to [Eric Geloen](https://github.com/egeloen)!
* [#2296](https://github.com/ckeditor/ckeditor-dev/issues/2296): Fixed: The [Color Button](https://ckeditor.com/cke4/addon/colorbutton) plugin throws an error when activated on content containing HTML comments.
* [#966](https://github.com/ckeditor/ckeditor-dev/issues/966): Fixed: Executing [`editor.destroy()`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_editor.html#method-destroy) during the [file upload](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_fileTools_uploadWidgetDefinition.html#property-onUploading) throws an error. Thanks to [Maksim Makarevich](https://github.com/MaksimMakarevich)!
* [#1719](https://github.com/ckeditor/ckeditor-dev/issues/1719): Fixed: <kbd>Ctrl</kbd>/<kbd>Cmd</kbd> + <kbd>A</kbd> inadvertently focuses inline editor if it is starting and ending with a list. Thanks to [theNailz](https://github.com/theNailz)!
* [#1046](https://github.com/ckeditor/ckeditor-dev/issues/1046): Fixed: Subsequent new links do not include the `id` attribute. Thanks to [Nathan Samson](https://github.com/nathansamson)!
* [#1348](https://github.com/ckeditor/ckeditor-dev/issues/1348): Fixed: [Enhanced Image](https://ckeditor.com/cke4/addon/image2) plugin aspect ratio locking uses an old width and height on image URL change.
* [#1791](https://github.com/ckeditor/ckeditor-dev/issues/1791): Fixed: [Image](https://ckeditor.com/cke4/addon/image) and [Enhanced Image](https://ckeditor.com/cke4/addon/image2) plugins can be enabled when [Easy Image](https://ckeditor.com/cke4/addon/easyimage) is present.
* [#2254](https://github.com/ckeditor/ckeditor-dev/issues/2254): Fixed: [Image](https://ckeditor.com/cke4/addon/image) ratio locking is too precise for resized images. Thanks to [Jonathan Gilbert](https://github.com/logiclrd)!
* [#1184](https://github.com/ckeditor/ckeditor-dev/issues/1184): [IE8-11] Fixed: Copying and pasting data in [read-only mode](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_editor.html#property-readOnly) throws an error.
* [#1916](https://github.com/ckeditor/ckeditor-dev/issues/1916): [IE9-11] Fixed: Pressing the <kbd>Delete</kbd> key in [read-only mode](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_editor.html#property-readOnly) throws an error.
* [#2003](https://github.com/ckeditor/ckeditor-dev/issues/2003): [Firefox] Fixed: Right-clicking multiple selected table cells containing empty paragraphs removes the selection.
* [#1816](https://github.com/ckeditor/ckeditor-dev/issues/1816): Fixed: Table breaks when <kbd>Enter</kbd> is pressed over the [Table Selection](https://ckeditor.com/cke4/addon/tableselection) plugin.
* [#1115](https://github.com/ckeditor/ckeditor-dev/issues/1115): Fixed: The `<font>` tag is not preserved when proper configuration is provided and a style is applied by the [Font](https://ckeditor.com/cke4/addon/font) plugin.
* [#727](https://github.com/ckeditor/ckeditor-dev/issues/727): Fixed: Custom styles may be invisible in the [Styles Combo](https://ckeditor.com/cke4/addon/stylescombo) plugin.
* [#988](https://github.com/ckeditor/ckeditor-dev/issues/988): Fixed: ACF-enabled custom elements prefixed with `object`, `embed`, `param` are removed from the editor content.

API Changes:

* [#2249](https://github.com/ckeditor/ckeditor-dev/issues/1791): Added the [`editor.plugins.detectConflict()`](https://ckeditor.com/docs/ckeditor4/latest/CKEDITOR_editor_plugins.html#method-detectConflict) method finding conflicts between provided plugins.

## CKEditor 4.10

New Features:

* [#1751](https://github.com/ckeditor/ckeditor-dev/issues/1751): Introduced the **Autocomplete** feature that consists of the following plugins:
	* [Autocomplete](https://ckeditor.com/cke4/addon/autocomplete) &ndash; Provides contextual completion feature for custom text matches based on user input.
	* [Text Watcher](https://ckeditor.com/cke4/addon/textWatcher) &ndash; Checks whether an editor's text change matches the chosen criteria.
	* [Text Match](https://ckeditor.com/cke4/addon/textMatch) &ndash; Allows to search [`CKEDITOR.dom.range`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_dom_range.html) for matching text.
* [#1703](https://github.com/ckeditor/ckeditor-dev/issues/1703): Introduced the [Mentions](https://ckeditor.com/cke4/addon/mentions) plugin providing smart completion feature for custom text matches based on user input starting with a chosen marker character.
* [#1746](https://github.com/ckeditor/ckeditor-dev/issues/1703): Introduced the [Emoji](https://ckeditor.com/cke4/addon/emoji) plugin providing completion feature for emoji ideograms.
* [#1761](https://github.com/ckeditor/ckeditor-dev/issues/1761): The [Auto Link](https://ckeditor.com/cke4/addon/autolink) plugin now supports email links.

Fixed Issues:

* [#1458](https://github.com/ckeditor/ckeditor-dev/issues/1458): [Edge] Fixed: After blurring the editor it takes 2 clicks to focus a widget.
* [#1034](https://github.com/ckeditor/ckeditor-dev/issues/1034): Fixed: JAWS leaves forms mode after pressing the <kbd>Enter</kbd> key in an inline editor instance.
* [#1748](https://github.com/ckeditor/ckeditor-dev/pull/1748): Fixed: Missing [`CKEDITOR.dialog.definition.onHide`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_dialog_definition.html#property-onHide) API documentation. Thanks to [sunnyone](https://github.com/sunnyone)!
* [#1321](https://github.com/ckeditor/ckeditor-dev/issues/1321): Fixed: Ideographic space character (`\u3000`) is lost when pasting text.
* [#1776](https://github.com/ckeditor/ckeditor-dev/issues/1776): Fixed: Empty caption placeholder of the [Image Base](https://ckeditor.com/cke4/addon/imagebase) plugin is not hidden when blurred.
* [#1592](https://github.com/ckeditor/ckeditor-dev/issues/1592): Fixed: The [Image Base](https://ckeditor.com/cke4/addon/imagebase) plugin caption is not visible after paste.
* [#620](https://github.com/ckeditor/ckeditor-dev/issues/620): Fixed: The [`config.forcePasteAsPlainText`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html#cfg-forcePasteAsPlainText) option is not respected in internal and cross-editor pasting.
* [#1467](https://github.com/ckeditor/ckeditor-dev/issues/1467): Fixed: The resizing cursor of the [Table Resize](https://ckeditor.com/cke4/addon/tableresize) plugin appearing in the middle of a merged cell.

API Changes:

* [#850](https://github.com/ckeditor/ckeditor-dev/issues/850): Backward incompatibility: Replaced the `replace` dialog from the [Find / Replace](https://ckeditor.com/cke4/addon/find) plugin with a `tabId` option in the `find` command.
* [#1582](https://github.com/ckeditor/ckeditor-dev/issues/1582): The [`CKEDITOR.editor.addCommand()`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_editor.html#method-addCommand) method can now accept a [`CKEDITOR.command`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_command.html) instance as a parameter.
* [#1712](https://github.com/ckeditor/ckeditor-dev/issues/1712): The [`extraPlugins`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html#cfg-extraPlugins), [`removePlugins`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html#cfg-removePlugins) and [`plugins`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html#cfg-plugins) configuration options allow whitespace.
* [#1802](https://github.com/ckeditor/ckeditor-dev/issues/1802): The [`extraPlugins`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html#cfg-extraPlugins), [`removePlugins`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html#cfg-removePlugins) and [`plugins`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html#cfg-plugins) configuration options allow passing plugin names as an array.
* [#1724](https://github.com/ckeditor/ckeditor-dev/issues/1724): Added an option to the [`getClientRect()`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_dom_element.html#method-getClientRect) function allowing to retrieve an absolute bounding rectangle of the element, i.e. a position relative to the upper-left corner of the topmost viewport.
* [#1498](https://github.com/ckeditor/ckeditor-dev/issues/1498) : Added a new [`getClientRects()`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_dom_range.html#method-getClientRects) method to `CKEDITOR.dom.range`. It returns a list of rectangles for each selected element.
* [#1993](https://github.com/ckeditor/ckeditor-dev/issues/1993): Added the [`CKEDITOR.tools.throttle()`](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_tools.html#method-throttle) function.

Other Changes:

* Updated [SCAYT](https://ckeditor.com/cke4/addon/scayt) (Spell Check As You Type) and [WebSpellChecker](https://ckeditor.com/cke4/addon/wsc) (WSC) plugins:
	* Language dictionary update: Added support for the Uzbek Latin language.
	* Languages no longer supported as additional languages: Manx - Isle of Man (`gv_GB`) and Interlingua (`ia_XR`).
	* Extended and improved language dictionaries: Georgian and Swedish. Also added the missing word _"Ensure"_ to the American, British and Canada English language.
	* [#141](https://github.com/WebSpellChecker/ckeditor-plugin-scayt/issues/141) Fixed: SCAYT throws "Uncaught Error: Error in RangyWrappedRange module: createRange(): Parameter must be a Window object or DOM node".
	* [#153](https://github.com/WebSpellChecker/ckeditor-plugin-scayt/issues/153) [Chrome] Fixed: Correctin