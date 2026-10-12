"use strict";
(self["webpackChunksolace"] = self["webpackChunksolace"] || []).push([["order"],{

/***/ "./assets/apps/customizer-controls/src/new-ordering/Ordering.js":
/*!**********************************************************************!*\
  !*** ./assets/apps/customizer-controls/src/new-ordering/Ordering.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_sortablejs__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-sortablejs */ "./node_modules/react-sortablejs/dist/index.js");
/* harmony import */ var react_sortablejs__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_sortablejs__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(prop_types__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);







const Handle = ({
  isDragging
}) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Tooltip, {
  text: isDragging ? '' : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Drag to Reorder', 'solace')
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
  "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Drag to Reorder', 'solace'),
  className: "handle",
  onClick: e => {
    e.preventDefault();
  }
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
  width: "15",
  height: "15",
  viewBox: "0 0 15 15",
  fill: "none",
  xmlns: "http://www.w3.org/2000/svg"
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
  d: "M12.6024 6.83408L11.8344 6.06108C11.7668 5.99835 11.7125 5.92265 11.6749 5.83848C11.6372 5.75432 11.6169 5.66343 11.6152 5.57125C11.6135 5.47906 11.6303 5.38748 11.6648 5.30196C11.6993 5.21644 11.7506 5.13874 11.8158 5.07351C11.8809 5.00828 11.9586 4.95686 12.044 4.92231C12.1295 4.88776 12.2211 4.8708 12.3133 4.87244C12.4055 4.87408 12.4964 4.89429 12.5806 4.93186C12.6648 4.96942 12.7406 5.02358 12.8034 5.09108L14.7424 7.03108C14.8706 7.15969 14.9427 7.33393 14.9427 7.51558C14.9427 7.69724 14.8706 7.87148 14.7424 8.00008L12.8034 9.93908C12.7397 10.0027 12.6642 10.0532 12.5811 10.0876C12.4979 10.122 12.4088 10.1398 12.3189 10.1398C12.2289 10.1398 12.1398 10.122 12.0566 10.0876C11.9735 10.0532 11.898 10.0027 11.8344 9.93908C11.7707 9.87546 11.7203 9.79992 11.6858 9.71679C11.6514 9.63366 11.6337 9.54456 11.6337 9.45458C11.6337 9.3646 11.6514 9.27551 11.6858 9.19238C11.7203 9.10924 11.7707 9.03371 11.8344 8.97008L12.6024 8.20208H8.15635V12.6511L8.92435 11.8831C8.98798 11.8195 9.06351 11.769 9.14664 11.7346C9.22977 11.7001 9.31887 11.6824 9.40885 11.6824C9.49883 11.6824 9.58793 11.7001 9.67106 11.7346C9.75419 11.769 9.82973 11.8195 9.89335 11.8831C9.95698 11.9467 10.0074 12.0222 10.0419 12.1054C10.0763 12.1885 10.094 12.2776 10.094 12.3676C10.094 12.4576 10.0763 12.5467 10.0419 12.6298C10.0074 12.7129 9.95698 12.7885 9.89335 12.8521L7.95535 14.7921C7.82675 14.9204 7.65251 14.9924 7.47085 14.9924C7.28919 14.9924 7.11495 14.9204 6.98635 14.7921L5.04635 12.8521C4.98273 12.7885 4.93225 12.7129 4.89782 12.6298C4.86339 12.5467 4.84566 12.4576 4.84566 12.3676C4.84566 12.2776 4.86339 12.1885 4.89782 12.1054C4.93225 12.0222 4.98272 11.9467 5.04635 11.8831C5.10998 11.8195 5.18551 11.769 5.26864 11.7346C5.35177 11.7001 5.44087 11.6824 5.53085 11.6824C5.62083 11.6824 5.70993 11.7001 5.79306 11.7346C5.87619 11.769 5.95173 11.8195 6.01535 11.8831L6.78435 12.6511V8.20508H2.33935L3.10835 8.97308C3.23685 9.10158 3.30904 9.27586 3.30904 9.45758C3.30904 9.63931 3.23685 9.81359 3.10835 9.94208C2.97985 10.0706 2.80557 10.1428 2.62385 10.1428C2.44213 10.1428 2.26785 10.0706 2.13935 9.94208L0.20035 8.00408C0.0720517 7.87548 0 7.70124 0 7.51958C0 7.33793 0.0720517 7.16369 0.20035 7.03508L2.14035 5.09508C2.20315 5.02758 2.27891 4.97342 2.36312 4.93586C2.44732 4.89829 2.53823 4.87808 2.63041 4.87644C2.7226 4.8748 2.81417 4.89176 2.89965 4.92631C2.98514 4.96086 3.06278 5.01228 3.12794 5.07751C3.19311 5.14274 3.24445 5.22044 3.27891 5.30595C3.31337 5.39147 3.33023 5.48306 3.3285 5.57525C3.32676 5.66743 3.30646 5.75832 3.26881 5.84248C3.23115 5.92665 3.17692 6.00235 3.10935 6.06508L2.34035 6.83308H6.78635V2.38908L6.01635 3.16108C5.95272 3.22471 5.87719 3.27518 5.79406 3.30961C5.71093 3.34405 5.62183 3.36177 5.53185 3.36177C5.44187 3.36177 5.35277 3.34405 5.26964 3.30961C5.18651 3.27518 5.11098 3.22471 5.04735 3.16108C4.98373 3.09746 4.93325 3.02192 4.89882 2.93879C4.86439 2.85566 4.84666 2.76656 4.84666 2.67658C4.84666 2.5866 4.86439 2.49751 4.89882 2.41438C4.93325 2.33124 4.98373 2.25571 5.04735 2.19208L6.98735 0.253085C7.11595 0.124786 7.29019 0.0527344 7.47185 0.0527344C7.65351 0.0527344 7.82775 0.124786 7.95635 0.253085L9.89535 2.19308C9.96428 2.25532 10.0198 2.33092 10.0586 2.41529C10.0975 2.49966 10.1187 2.59104 10.1211 2.68388C10.1235 2.77671 10.107 2.86907 10.0726 2.95533C10.0382 3.04159 9.98658 3.11995 9.92094 3.18565C9.85531 3.25135 9.777 3.30302 9.69078 3.33752C9.60455 3.37202 9.51222 3.38862 9.41938 3.38632C9.32654 3.38403 9.23513 3.36287 9.15072 3.32415C9.06631 3.28543 8.99065 3.22995 8.92835 3.16108L8.16035 2.39308V6.83408H12.6063H12.6024Z",
  fill: "white"
}))));
const Item = ({
  item,
  onToggle,
  components,
  controlID,
  allowsToggle = true,
  isDragging
}) => {
  const label = item.id.replace('solace_product_page_ordering_card_options', '').replace(/solace_single_post_element/g, '').replace(/solhide/g, '').replace(/-/g, ' ').split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
  const uniqueID = `${controlID}-${label}`.toLowerCase().replace(/[-\s]/g, '_').replace(/_$/, '');
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_2___default()({
      'solace-sortable-item': true,
      'no-toggle': !allowsToggle,
      disabled: item.id.includes('solhide'),
      visible: !item.id.includes('solhide')
    })
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('left', 'solace')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Handle, {
    isDragging: isDragging
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "label"
  }, label)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('right', 'solace')
  }, allowsToggle && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Tooltip, {
    text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Toggle Visibility', 'solace')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Toggle Visibility', 'solace'),
    className: "toggle",
    onClick: e => {
      e.preventDefault();
      e.stopPropagation();
      onToggle(item.id);
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    width: "19",
    height: "19",
    viewBox: "0 0 19 19",
    xmlns: "http://www.w3.org/2000/svg"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("g", {
    clipPath: "url(#clip0_2561_341)"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M9.5 3.83789C5.86985 3.83789 2.57784 5.82398 0.148665 9.04992C-0.0495551 9.31421 -0.0495551 9.68345 0.148665 9.94774C2.57784 13.1776 5.86985 15.1637 9.5 15.1637C13.1302 15.1637 16.4222 13.1776 18.8513 9.95163C19.0496 9.68733 19.0496 9.3181 18.8513 9.05381C16.4222 5.82398 13.1302 3.83789 9.5 3.83789ZM9.76041 13.4885C7.35067 13.6401 5.36069 11.654 5.51227 9.24037C5.63665 7.25039 7.24962 5.63742 9.23959 5.51305C11.6493 5.36147 13.6393 7.34756 13.4877 9.76118C13.3595 11.7473 11.7465 13.3602 9.76041 13.4885ZM9.63992 11.6462C8.34177 11.7278 7.26905 10.659 7.35456 9.36085C7.42063 8.28813 8.29124 7.4214 9.36397 7.35144C10.6621 7.26982 11.7348 8.33866 11.6493 9.63681C11.5794 10.7134 10.7088 11.5801 9.63992 11.6462Z"
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("defs", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("clipPath", {
    id: "clip0_2561_341"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("rect", {
    width: "19",
    height: "19",
    fill: "white"
  })))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Tooltip, {
    text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Toggle Setting', 'solace')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    id: uniqueID.toLowerCase().replace(/\s+/g, '-'),
    className: "move",
    "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Toggle Setting', 'solace')
    // className={`move popover-${label.toLowerCase().replace(/\s+/g, '-')}`}
    // style={{ visibility: 'hidden', margin: 0, width: 0 }}
    ,
    onClick: e => {
      e.preventDefault();
      // 	e.stopPropagation();
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    id: `svg-${uniqueID.toLowerCase().replace(/\s+/g, '-')}`,
    width: "15",
    height: "15",
    viewBox: "0 0 15 15",
    fill: "none",
    xmlns: "http://www.w3.org/2000/svg"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("g", {
    id: `g-${uniqueID.toLowerCase().replace(/\s+/g, '-')}`,
    clipPath: "url(#clip0_2561_356)"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    id: `path1-${uniqueID.toLowerCase().replace(/\s+/g, '-')}`,
    d: "M14.3598 0.505529L14.3418 0.489062C13.9965 0.173698 13.549 0 13.0816 0C12.5576 0 12.0545 0.221808 11.7013 0.608501L5.02207 7.92092C4.96119 7.98756 4.91501 8.06619 4.88646 8.1518L4.10108 10.5063C4.01028 10.7785 4.05585 11.0795 4.22297 11.3115C4.39143 11.5453 4.66281 11.6849 4.94898 11.6849C5.07276 11.6849 5.19379 11.6595 5.30854 11.6092L7.58252 10.6144C7.6652 10.5783 7.73936 10.5252 7.8002 10.4585L14.4795 3.14616C15.1745 2.38529 15.1209 1.20079 14.3598 0.505529ZM5.60585 10.0713L6.06671 8.68974L6.10557 8.64718L6.97905 9.44498L6.94018 9.48755L5.60585 10.0713ZM13.5272 2.27626L7.84895 8.4927L6.97548 7.69489L12.6537 1.47841C12.7647 1.35682 12.9167 1.28983 13.0816 1.28983C13.2263 1.28983 13.3649 1.34366 13.4721 1.4416L13.4901 1.45807C13.7259 1.67343 13.7425 2.04047 13.5272 2.27626Z",
    fill: "#FF9400"
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    id: `path2-${uniqueID.toLowerCase().replace(/\s+/g, '-')}`,
    d: "M13.064 5.94938C12.7079 5.94938 12.4191 6.23813 12.4191 6.5943V12.0695C12.4191 12.9739 11.6834 13.7096 10.779 13.7096H2.96266C2.05827 13.7096 1.32255 12.9739 1.32255 12.0695V4.31666C1.32255 3.41232 2.05831 2.67655 2.96266 2.67655H8.62017C8.97634 2.67655 9.26509 2.3878 9.26509 2.03164C9.26509 1.67547 8.97634 1.38672 8.62017 1.38672H2.96266C1.34706 1.38672 0.0327148 2.7011 0.0327148 4.31666V12.0695C0.0327148 13.685 1.3471 14.9994 2.96266 14.9994H10.779C12.3945 14.9994 13.7089 13.685 13.7089 12.0695V6.5943C13.709 6.23813 13.4202 5.94938 13.064 5.94938Z",
    fill: "#FF9400"
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("defs", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("clipPath", {
    id: "clip0_2561_356"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("rect", {
    width: "15",
    height: "15",
    fill: "white"
  }))))))));
};
Item.propTypes = {
  item: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().object).isRequired,
  onToggle: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().func).isRequired,
  allowsToggle: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().bool).isRequired,
  className: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().string),
  disabled: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().bool)
};
const Ordering = ({
  label,
  onUpdate,
  value,
  components,
  controlID,
  allowsToggle = true
}) => {
  const [isDragging, setIsDragging] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const handleToggle = item => {
    const newValue = value.map(e => {
      if (e.id === item) {
        if (e.id.endsWith('-solhide')) {
          e.id = e.id.replace('-solhide', '');
        } else {
          e.id = e.id + '-solhide';
        }
      }
      return e;
    });
    handleChange(newValue);
  };
  const handleChange = newVal => {
    onUpdate(newVal);
  };
  value = value.filter(element => {
    return element.id;
  });
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, label /* TODO: Add proper label id for this */ && /* eslint-disable-next-line jsx-a11y/label-has-for */
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    className: "customize-control-title"
  }, label), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(react_sortablejs__WEBPACK_IMPORTED_MODULE_1__.ReactSortable, {
    className: "items-list",
    list: value,
    setList: handleChange,
    animation: 300,
    handle: ".handle",
    onStart: () => setIsDragging(true),
    onEnd: () => setIsDragging(false)
  }, value.filter(element => {
    return element.id;
  }).map((item, index) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Item, {
    key: 'ordering-element-' + index,
    item: item,
    onToggle: handleToggle,
    allowsToggle: allowsToggle,
    components: components,
    controlID: controlID,
    isDragging: isDragging
  }))));
};
Ordering.propTypes = {
  label: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().string).isRequired,
  onUpdate: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().func).isRequired,
  value: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().array).isRequired,
  allowsToggle: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().bool),
  components: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().object).isRequired,
  controlID: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().string)
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Ordering);

/***/ }),

/***/ "./assets/apps/customizer-controls/src/ordering/Ordering.js":
/*!******************************************************************!*\
  !*** ./assets/apps/customizer-controls/src/ordering/Ordering.js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_sortablejs__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-sortablejs */ "./node_modules/react-sortablejs/dist/index.js");
/* harmony import */ var react_sortablejs__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_sortablejs__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(prop_types__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);






const Handle = () => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Tooltip, {
  text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Drag to Reorder', 'solace')
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
  "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Drag to Reorder', 'solace'),
  className: "handle",
  onClick: e => {
    e.preventDefault();
  }
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Icon, {
  icon: "menu"
})));
const Item = ({
  item,
  onToggle,
  components,
  allowsToggle = true
}) => {
  const label = components[item.id];
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_2___default()({
      'solace-sortable-item': true,
      'no-toggle': !allowsToggle,
      visible: item.visible,
      disabled: !item.visible
    })
  }, allowsToggle && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Tooltip, {
    text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Toggle Visibility', 'solace')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Toggle Visibility', 'solace'),
    className: "toggle",
    onClick: e => {
      e.preventDefault();
      e.stopPropagation();
      onToggle(item.id);
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Icon, {
    icon: "visibility"
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "label"
  }, label), item.visible && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Handle, null));
};
Item.propTypes = {
  item: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().object).isRequired,
  onToggle: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().func).isRequired,
  allowsToggle: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().bool).isRequired,
  className: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().string),
  disabled: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().bool)
};
const Ordering = ({
  label,
  onUpdate,
  value,
  components,
  allowsToggle = true
}) => {
  const handleToggle = item => {
    const newValue = value.map(e => {
      if (e.id === item) {
        e.visible = !e.visible;
      }
      return e;
    });
    handleChange(newValue);
  };
  const handleChange = newVal => {
    const updatedValue = newVal.sort((x, y) => {
      if (x.visible === y.visible) {
        return 0;
      }
      if (x.visible) {
        return -1;
      }
      return 1;
    });
    onUpdate(updatedValue);
  };
  value = value.filter(element => {
    return components.hasOwnProperty(element.id);
  });
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, label /* TODO: Add proper label id for this */ && /* eslint-disable-next-line jsx-a11y/label-has-for */
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    className: "customize-control-title"
  }, label), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(react_sortablejs__WEBPACK_IMPORTED_MODULE_1__.ReactSortable, {
    className: "items-list",
    list: value,
    setList: handleChange,
    animation: 300,
    handle: ".handle"
  }, value.filter(element => {
    return components.hasOwnProperty(element.id);
  }).map((item, index) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Item, {
    key: 'ordering-element-' + index,
    item: item,
    onToggle: handleToggle,
    allowsToggle: allowsToggle,
    components: components
  }))));
};
Ordering.propTypes = {
  label: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().string).isRequired,
  onUpdate: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().func).isRequired,
  value: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().array).isRequired,
  allowsToggle: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().bool),
  components: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().object).isRequired
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Ordering);

/***/ }),

/***/ "./assets/apps/customizer-controls/src/solace-sortable/SolaceSortableOrdering.js":
/*!***************************************************************************************!*\
  !*** ./assets/apps/customizer-controls/src/solace-sortable/SolaceSortableOrdering.js ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_sortablejs__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-sortablejs */ "./node_modules/react-sortablejs/dist/index.js");
/* harmony import */ var react_sortablejs__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_sortablejs__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(prop_types__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);







const Handle = ({
  isDragging
}) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Tooltip, {
  text: isDragging ? '' : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Drag to Reorder', 'solace')
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
  "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Drag to Reorder', 'solace'),
  className: "handle",
  onClick: e => {
    e.preventDefault();
  }
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
  width: "15",
  height: "15",
  viewBox: "0 0 15 15",
  fill: "none",
  xmlns: "http://www.w3.org/2000/svg"
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
  d: "M12.6024 6.83408L11.8344 6.06108C11.7668 5.99835 11.7125 5.92265 11.6749 5.83848C11.6372 5.75432 11.6169 5.66343 11.6152 5.57125C11.6135 5.47906 11.6303 5.38748 11.6648 5.30196C11.6993 5.21644 11.7506 5.13874 11.8158 5.07351C11.8809 5.00828 11.9586 4.95686 12.044 4.92231C12.1295 4.88776 12.2211 4.8708 12.3133 4.87244C12.4055 4.87408 12.4964 4.89429 12.5806 4.93186C12.6648 4.96942 12.7406 5.02358 12.8034 5.09108L14.7424 7.03108C14.8706 7.15969 14.9427 7.33393 14.9427 7.51558C14.9427 7.69724 14.8706 7.87148 14.7424 8.00008L12.8034 9.93908C12.7397 10.0027 12.6642 10.0532 12.5811 10.0876C12.4979 10.122 12.4088 10.1398 12.3189 10.1398C12.2289 10.1398 12.1398 10.122 12.0566 10.0876C11.9735 10.0532 11.898 10.0027 11.8344 9.93908C11.7707 9.87546 11.7203 9.79992 11.6858 9.71679C11.6514 9.63366 11.6337 9.54456 11.6337 9.45458C11.6337 9.3646 11.6514 9.27551 11.6858 9.19238C11.7203 9.10924 11.7707 9.03371 11.8344 8.97008L12.6024 8.20208H8.15635V12.6511L8.92435 11.8831C8.98798 11.8195 9.06351 11.769 9.14664 11.7346C9.22977 11.7001 9.31887 11.6824 9.40885 11.6824C9.49883 11.6824 9.58793 11.7001 9.67106 11.7346C9.75419 11.769 9.82973 11.8195 9.89335 11.8831C9.95698 11.9467 10.0074 12.0222 10.0419 12.1054C10.0763 12.1885 10.094 12.2776 10.094 12.3676C10.094 12.4576 10.0763 12.5467 10.0419 12.6298C10.0074 12.7129 9.95698 12.7885 9.89335 12.8521L7.95535 14.7921C7.82675 14.9204 7.65251 14.9924 7.47085 14.9924C7.28919 14.9924 7.11495 14.9204 6.98635 14.7921L5.04635 12.8521C4.98273 12.7885 4.93225 12.7129 4.89782 12.6298C4.86339 12.5467 4.84566 12.4576 4.84566 12.3676C4.84566 12.2776 4.86339 12.1885 4.89782 12.1054C4.93225 12.0222 4.98272 11.9467 5.04635 11.8831C5.10998 11.8195 5.18551 11.769 5.26864 11.7346C5.35177 11.7001 5.44087 11.6824 5.53085 11.6824C5.62083 11.6824 5.70993 11.7001 5.79306 11.7346C5.87619 11.769 5.95173 11.8195 6.01535 11.8831L6.78435 12.6511V8.20508H2.33935L3.10835 8.97308C3.23685 9.10158 3.30904 9.27586 3.30904 9.45758C3.30904 9.63931 3.23685 9.81359 3.10835 9.94208C2.97985 10.0706 2.80557 10.1428 2.62385 10.1428C2.44213 10.1428 2.26785 10.0706 2.13935 9.94208L0.20035 8.00408C0.0720517 7.87548 0 7.70124 0 7.51958C0 7.33793 0.0720517 7.16369 0.20035 7.03508L2.14035 5.09508C2.20315 5.02758 2.27891 4.97342 2.36312 4.93586C2.44732 4.89829 2.53823 4.87808 2.63041 4.87644C2.7226 4.8748 2.81417 4.89176 2.89965 4.92631C2.98514 4.96086 3.06278 5.01228 3.12794 5.07751C3.19311 5.14274 3.24445 5.22044 3.27891 5.30595C3.31337 5.39147 3.33023 5.48306 3.3285 5.57525C3.32676 5.66743 3.30646 5.75832 3.26881 5.84248C3.23115 5.92665 3.17692 6.00235 3.10935 6.06508L2.34035 6.83308H6.78635V2.38908L6.01635 3.16108C5.95272 3.22471 5.87719 3.27518 5.79406 3.30961C5.71093 3.34405 5.62183 3.36177 5.53185 3.36177C5.44187 3.36177 5.35277 3.34405 5.26964 3.30961C5.18651 3.27518 5.11098 3.22471 5.04735 3.16108C4.98373 3.09746 4.93325 3.02192 4.89882 2.93879C4.86439 2.85566 4.84666 2.76656 4.84666 2.67658C4.84666 2.5866 4.86439 2.49751 4.89882 2.41438C4.93325 2.33124 4.98373 2.25571 5.04735 2.19208L6.98735 0.253085C7.11595 0.124786 7.29019 0.0527344 7.47185 0.0527344C7.65351 0.0527344 7.82775 0.124786 7.95635 0.253085L9.89535 2.19308C9.96428 2.25532 10.0198 2.33092 10.0586 2.41529C10.0975 2.49966 10.1187 2.59104 10.1211 2.68388C10.1235 2.77671 10.107 2.86907 10.0726 2.95533C10.0382 3.04159 9.98658 3.11995 9.92094 3.18565C9.85531 3.25135 9.777 3.30302 9.69078 3.33752C9.60455 3.37202 9.51222 3.38862 9.41938 3.38632C9.32654 3.38403 9.23513 3.36287 9.15072 3.32415C9.06631 3.28543 8.99065 3.22995 8.92835 3.16108L8.16035 2.39308V6.83408H12.6063H12.6024Z",
  fill: "white"
}))));
const ItemProductElements = ({
  item,
  onToggle,
  components,
  controlID,
  allowsToggle = true,
  isDragging
}) => {
  const label = item.id.replace('solace_single_product_product_elements-', '').replace(/solhide/g, '').replace(/-/g, ' ').split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
  const uniqueID = `${controlID}-${label}`.toLowerCase().replace(/[-\s]/g, '_').replace(/_$/, '');
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_2___default()({
      'solace-sortable-item': true,
      'no-toggle': !allowsToggle,
      disabled: item.id.includes('solhide'),
      visible: !item.id.includes('solhide')
    })
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('left', 'solace')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Handle, {
    isDragging: isDragging
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "label"
  }, label)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('right', 'solace')
  }, allowsToggle && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Tooltip, {
    text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Toggle Visibility', 'solace')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Toggle Visibility', 'solace'),
    className: "toggle",
    onClick: e => {
      e.preventDefault();
      e.stopPropagation();
      onToggle(item.id);
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    width: "19",
    height: "19",
    viewBox: "0 0 19 19",
    xmlns: "http://www.w3.org/2000/svg"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("g", {
    clipPath: "url(#clip0_2561_341)"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M9.5 3.83789C5.86985 3.83789 2.57784 5.82398 0.148665 9.04992C-0.0495551 9.31421 -0.0495551 9.68345 0.148665 9.94774C2.57784 13.1776 5.86985 15.1637 9.5 15.1637C13.1302 15.1637 16.4222 13.1776 18.8513 9.95163C19.0496 9.68733 19.0496 9.3181 18.8513 9.05381C16.4222 5.82398 13.1302 3.83789 9.5 3.83789ZM9.76041 13.4885C7.35067 13.6401 5.36069 11.654 5.51227 9.24037C5.63665 7.25039 7.24962 5.63742 9.23959 5.51305C11.6493 5.36147 13.6393 7.34756 13.4877 9.76118C13.3595 11.7473 11.7465 13.3602 9.76041 13.4885ZM9.63992 11.6462C8.34177 11.7278 7.26905 10.659 7.35456 9.36085C7.42063 8.28813 8.29124 7.4214 9.36397 7.35144C10.6621 7.26982 11.7348 8.33866 11.6493 9.63681C11.5794 10.7134 10.7088 11.5801 9.63992 11.6462Z"
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("defs", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("clipPath", {
    id: "clip0_2561_341"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("rect", {
    width: "19",
    height: "19",
    fill: "white"
  })))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Tooltip, {
    text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Toggle Setting', 'solace')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    id: uniqueID.toLowerCase().replace(/\s+/g, '-'),
    className: "move",
    "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Toggle Setting', 'solace')
    // className={`move popover-${label.toLowerCase().replace(/\s+/g, '-')}`}
    // style={{ visibility: 'hidden', margin: 0, width: 0 }}
    ,
    onClick: e => {
      e.preventDefault();
      // 	e.stopPropagation();
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    id: `svg-${uniqueID.toLowerCase().replace(/\s+/g, '-')}`,
    width: "15",
    height: "15",
    viewBox: "0 0 15 15",
    fill: "none",
    xmlns: "http://www.w3.org/2000/svg"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("g", {
    id: `g-${uniqueID.toLowerCase().replace(/\s+/g, '-')}`,
    clipPath: "url(#clip0_2561_356)"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    id: `path1-${uniqueID.toLowerCase().replace(/\s+/g, '-')}`,
    d: "M14.3598 0.505529L14.3418 0.489062C13.9965 0.173698 13.549 0 13.0816 0C12.5576 0 12.0545 0.221808 11.7013 0.608501L5.02207 7.92092C4.96119 7.98756 4.91501 8.06619 4.88646 8.1518L4.10108 10.5063C4.01028 10.7785 4.05585 11.0795 4.22297 11.3115C4.39143 11.5453 4.66281 11.6849 4.94898 11.6849C5.07276 11.6849 5.19379 11.6595 5.30854 11.6092L7.58252 10.6144C7.6652 10.5783 7.73936 10.5252 7.8002 10.4585L14.4795 3.14616C15.1745 2.38529 15.1209 1.20079 14.3598 0.505529ZM5.60585 10.0713L6.06671 8.68974L6.10557 8.64718L6.97905 9.44498L6.94018 9.48755L5.60585 10.0713ZM13.5272 2.27626L7.84895 8.4927L6.97548 7.69489L12.6537 1.47841C12.7647 1.35682 12.9167 1.28983 13.0816 1.28983C13.2263 1.28983 13.3649 1.34366 13.4721 1.4416L13.4901 1.45807C13.7259 1.67343 13.7425 2.04047 13.5272 2.27626Z",
    fill: "#FF9400"
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    id: `path2-${uniqueID.toLowerCase().replace(/\s+/g, '-')}`,
    d: "M13.064 5.94938C12.7079 5.94938 12.4191 6.23813 12.4191 6.5943V12.0695C12.4191 12.9739 11.6834 13.7096 10.779 13.7096H2.96266C2.05827 13.7096 1.32255 12.9739 1.32255 12.0695V4.31666C1.32255 3.41232 2.05831 2.67655 2.96266 2.67655H8.62017C8.97634 2.67655 9.26509 2.3878 9.26509 2.03164C9.26509 1.67547 8.97634 1.38672 8.62017 1.38672H2.96266C1.34706 1.38672 0.0327148 2.7011 0.0327148 4.31666V12.0695C0.0327148 13.685 1.3471 14.9994 2.96266 14.9994H10.779C12.3945 14.9994 13.7089 13.685 13.7089 12.0695V6.5943C13.709 6.23813 13.4202 5.94938 13.064 5.94938Z",
    fill: "#FF9400"
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("defs", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("clipPath", {
    id: "clip0_2561_356"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("rect", {
    width: "15",
    height: "15",
    fill: "white"
  }))))))));
};
ItemProductElements.propTypes = {
  item: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().object).isRequired,
  onToggle: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().func).isRequired,
  allowsToggle: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().bool).isRequired,
  className: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().string),
  disabled: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().bool)
};
const SolaceSortableOrdering = ({
  label,
  onUpdate,
  value,
  components,
  controlID,
  allowsToggle = true
}) => {
  const [isDragging, setIsDragging] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const handleToggle = item => {
    const newValue = value.map(e => {
      if (e.id === item) {
        // e.visible = !e.visible;
        if (e.id.endsWith('-solhide')) {
          e.id = e.id.replace('-solhide', '');
        } else {
          e.id = e.id + '-solhide';
        }
      }
      return e;
    });
    handleChange(newValue);
  };
  const handleChange = newVal => {
    onUpdate(newVal);
  };
  value = value.filter(element => {
    return element.id;
  });
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, label /* TODO: Add proper label id for this */ && /* eslint-disable-next-line jsx-a11y/label-has-for */
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    className: "customize-control-title"
  }, label), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(react_sortablejs__WEBPACK_IMPORTED_MODULE_1__.ReactSortable, {
    className: "items-list",
    list: value,
    setList: handleChange,
    animation: 300,
    handle: ".handle",
    onStart: () => setIsDragging(true),
    onEnd: () => setIsDragging(false)
  }, value.filter(element => {
    return element.id;
  }).map((item, index) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ItemProductElements, {
    key: 'ordering-element-' + index,
    item: item,
    onToggle: handleToggle,
    allowsToggle: allowsToggle,
    components: components,
    controlID: controlID,
    isDragging: isDragging
  }))));
};
SolaceSortableOrdering.propTypes = {
  label: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().string).isRequired,
  onUpdate: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().func).isRequired,
  value: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().array).isRequired,
  allowsToggle: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().bool),
  components: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().object).isRequired,
  controlID: (prop_types__WEBPACK_IMPORTED_MODULE_5___default().string)
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (SolaceSortableOrdering);

/***/ })

}]);
//# sourceMappingURL=16c88f5a2452054a8ff6.js.map