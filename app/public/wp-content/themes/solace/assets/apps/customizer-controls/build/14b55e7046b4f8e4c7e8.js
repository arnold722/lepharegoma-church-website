"use strict";
(self["webpackChunksolace"] = self["webpackChunksolace"] || []).push([["assets_apps_customizer-controls_src_rich-text_RichText_js"],{

/***/ "./assets/apps/customizer-controls/src/rich-text/RichText.js":
/*!*******************************************************************!*\
  !*** ./assets/apps/customizer-controls/src/rich-text/RichText.js ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(prop_types__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _dynamic_fields_dynamic_field_inserter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../dynamic-fields/dynamic-field-inserter */ "./assets/apps/customizer-controls/src/dynamic-fields/dynamic-field-inserter.js");

/* global SolaceReactCustomize, Event */



const RichText = ({
  onChange,
  currentValue,
  label,
  id,
  toolbars,
  allowedDynamicFields
}) => {
  const textArea = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useRef)(null);
  const useDynamicFields = Boolean(Array.isArray(allowedDynamicFields) && allowedDynamicFields.length);
  const toolbarOneDefaults = 'formatselect,bold,italic,bullist,numlist,link,wp_adv';
  const toolbarTwoDefaults = 'strikethrough,hr,forecolor,pastetext,removeformat';
  const {
    toolbar1 = toolbarOneDefaults,
    toolbar2 = toolbarTwoDefaults
  } = toolbars;
  const editorId = `${id}-editor`;
  SolaceReactCustomize.fieldSelection = {};

  /**
   * Get the editor to be used based on the available version that WP loads.
   */
  const correctEditor = wp.oldEditor || wp.editor;

  /**
   * A listener to trigger the update state on change.
   */
  const listener = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useCallback)(() => onChange(correctEditor.getContent(editorId)), [editorId]);

  /**
   * Method to add a change listener for the current editor.
   */
  const addEditorChangeListener = () => {
    if (window.tinymce.editors[editorId]) {
      window.tinymce.editors[editorId].on('change', listener);
    }
  };

  /**
   * Method to remove a change listener for the current editor.
   */
  const removeEditorChangeListener = () => {
    if (window.tinymce.editors[editorId]) {
      window.tinymce.editors[editorId].off('change', listener);
    }
  };

  /**
   * Initialise the editor.
   */
  const initEditor = () => {
    correctEditor.initialize(editorId, {
      quicktags: true,
      mediaButtons: true,
      tinymce: {
        toolbar1,
        toolbar2,
        style_formats_merge: true,
        style_formats: [],
        verify_html: false
      }
    });
    setTimeout(addEditorChangeListener, 0);
    if (wp.oldEditor) {
      setTimeout(() => {
        removeEditorChangeListener();
        correctEditor.remove(editorId);
        correctEditor.initialize(editorId, {
          quicktags: true,
          mediaButtons: true,
          tinymce: {
            toolbar1,
            toolbar2,
            style_formats_merge: true,
            style_formats: [],
            verify_html: false
          }
        });
        setTimeout(addEditorChangeListener, 0);
      }, 300);
    }
  };

  /**
   * Method to update the editor content and state.
   *
   * @param {string} content The new content.
   */
  const setEditorContent = content => {
    onChange(content);
    window.tinymce.editors[editorId].setContent(content);
  };

  /**
   * Add dynamic tag to input field.
   *
   * @param {string} magicTag
   * @param {string} optionType
   */
  const addToField = function (magicTag, optionType) {
    let tag;
    const codeEditor = textArea.current;
    const isVisualEditor = !window.tinymce.editors[editorId].hidden;
    if (optionType === 'url') {
      tag = `<a href="{${magicTag}}">Link</a>`;
    } else {
      tag = `{${magicTag}}`;
    }
    if (isVisualEditor) {
      window.tinymce.editors[editorId].editorCommands.execCommand('mceInsertContent', false, tag);
      window.tinymce.editors[editorId].focus();
    } else {
      if (SolaceReactCustomize.fieldSelection[id]) {
        const {
          start,
          end
        } = SolaceReactCustomize.fieldSelection[id];
        const length = codeEditor.value.length;
        codeEditor.value = codeEditor.value.substring(0, start) + tag + codeEditor.value.substring(end, length);
      } else {
        codeEditor.value += tag;
      }
      codeEditor.focus();
    }
    codeEditor.dispatchEvent(new Event('change'));
  };
  const controlWrapperStyle = {
    position: 'relative'
  };
  const dynamicFieldStyle = {
    position: 'absolute',
    top: 0,
    right: '8px'
  };
  const textAreaStyle = {
    width: '100%'
  };
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    // We also hook here to listen for changes of the dynamic settings change to also trigger the editor content update.
    if (textArea && textArea.current) {
      textArea.current.addEventListener('change', () => {
        setEditorContent(textArea.current.value);
      });
      textArea.current.addEventListener('focusout', function (e) {
        SolaceReactCustomize.fieldSelection[id] = {
          start: e.target.selectionStart,
          end: e.target.selectionEnd
        };
      });
    }
    initEditor();
  }, []);

  // Re-init text editor content on conditional changes.
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    document.addEventListener('solace-changed-customizer-value', e => {
      if (!e.detail) return false;
      if (e.detail.id !== id) return false;
      setEditorContent(e.detail.value);
    });
  }, []);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "solace-white-background-control solace-rich-text",
    style: controlWrapperStyle
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "customize-control-title"
  }, label), useDynamicFields && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    style: dynamicFieldStyle
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_dynamic_fields_dynamic_field_inserter__WEBPACK_IMPORTED_MODULE_1__["default"], {
    options: SolaceReactCustomize?.dynamicTags?.options || [],
    allowedOptionsTypes: allowedDynamicFields,
    onSelect: (magicTag, group) => addToField(magicTag, group)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("textarea", {
    ref: textArea,
    id: editorId,
    className: "solace-custom-html-control-tinymce-editor mce-tinymce",
    value: currentValue,
    style: textAreaStyle,
    onChange: ({
      target: {
        value
      }
    }) => onChange(value)
  }));
};
RichText.propTypes = {
  id: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string).isRequired,
  toolbars: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().object),
  allowedDynamicFields: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().array),
  label: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string).isRequired,
  onChange: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().func).isRequired,
  currentValue: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string).isRequired
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (RichText);

/***/ })

}]);
//# sourceMappingURL=14b55e7046b4f8e4c7e8.js.map