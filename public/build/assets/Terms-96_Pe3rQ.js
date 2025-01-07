import { T as TextDivider } from "./TextDivider-B-8gwSCW.js";
import { F as FormInput } from "./FormInput-Ba17K5sb.js";
import { B as Button } from "./Button-BO2x471h.js";
import { C as Container } from "./Container-j8zTIzpm.js";
import { r as resolveComponent, c as createElementBlock, a as createVNode, w as withCtx, b as createBaseVNode, F as Fragment, o as openBlock, t as toDisplayString, e as createCommentVNode, f as createTextVNode } from "./app-B3WRWW1p.js";
import { _ as _export_sfc } from "./_plugin-vue_export-helper-1tPrXgE0.js";
const _sfc_main = {
  components: {
    TextDivider,
    FormInput,
    Button,
    Container
  },
  props: {
    content: {
      type: String,
      required: false
    }
  }
};
const _hoisted_1 = { class: "flex items-center justify-center w-full min-h-screen py-8 px-8" };
const _hoisted_2 = { class: "flex flex-col items-center space-y-5" };
const _hoisted_3 = ["src"];
const _hoisted_4 = { class: "flex justify-between" };
const _hoisted_5 = ["innerHTML"];
function _sfc_render(_ctx, _cache, $props, $setup, $data, $options) {
  const _component_Head = resolveComponent("Head");
  const _component_TextDivider = resolveComponent("TextDivider");
  const _component_inertia_link = resolveComponent("inertia-link");
  const _component_Container = resolveComponent("Container");
  return openBlock(), createElementBlock(Fragment, null, [
    createVNode(_component_Head, null, {
      default: withCtx(() => [
        createBaseVNode("title", null, toDisplayString(_ctx.__("Terms of Service")), 1)
      ], void 0, true),
      _: 1
    }),
    createBaseVNode("div", _hoisted_1, [
      createVNode(_component_Container, {
        size: "medium",
        class: "py-4 space-y-8"
      }, {
        default: withCtx(() => [
          createBaseVNode("div", _hoisted_2, [
            _ctx.$page.props.settings.logo ? (openBlock(), createElementBlock("img", {
              key: 0,
              class: "h-14",
              src: _ctx.$page.props.settings.logo
            }, null, 8, _hoisted_3)) : createCommentVNode("", true),
            _cache[0] || (_cache[0] = createBaseVNode("h1", { class: "font-semibold text-center text-heading" }, " Terms of Service ", -1))
          ]),
          createVNode(_component_TextDivider, { "without-text": true }),
          createBaseVNode("ul", _hoisted_4, [
            createBaseVNode("li", null, [
              createVNode(_component_inertia_link, {
                href: _ctx.route("login"),
                class: "text-medium-emphasis hover:text-high-emphasis border-b border-dotted"
              }, {
                default: withCtx(() => _cache[1] || (_cache[1] = [
                  createTextVNode("Back to login")
                ]), void 0, true),
                _: 1
              }, 8, ["href"])
            ])
          ]),
          createVNode(_component_TextDivider, { "without-text": true }),
          createBaseVNode("div", {
            class: "prose",
            innerHTML: $props.content
          }, null, 8, _hoisted_5)
        ], void 0, true),
        _: 1
      })
    ])
  ], 64);
}
const Terms = /* @__PURE__ */ _export_sfc(_sfc_main, [["render", _sfc_render]]);
export {
  Terms as default
};
