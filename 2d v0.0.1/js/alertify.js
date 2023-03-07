! function(t, k) {
    "use strict";
    var e, E = t.document;
    e = function() {
        var m, s, a, o, r, n = {},
            l = {},
            c = !1,
            v = 27,
            g = 32,
            f = [];
        return l = E.location.href.includes("mis_datos.php") ? {
            buttons: {
                holder: '<nav class="alertify-buttons">{{buttons}}</nav>',
                submit: '<button type="submit" class="alertify-button alertify-button-ok" id="alertify-ok" />{{ok}}</button>',
                ok: '<a href="#" class="alertify-button alertify-button-ok" id="alertify-ok">{{ok}}</a>',
                cancel: '<a href="#" class="alertify-button alertify-button-cancel" id="alertify-cancel">{{cancel}}</a>'
            },
            input: '<input type="password" class="alertify-text" id="alertify-text">',
            message: '<p class="alertify-message">{{message}}</p>',
            log: '<article class="alertify-log{{class}}">{{message}}</article>'
        } : {
            buttons: {
                holder: '<nav class="alertify-buttons">{{buttons}}</nav>',
                submit: '<button type="submit" class="alertify-button alertify-button-ok" id="alertify-ok" />{{ok}}</button>',
                ok: '<a href="#" class="alertify-button alertify-button-ok" id="alertify-ok">{{ok}}</a>',
                cancel: '<a href="#" class="alertify-button alertify-button-cancel" id="alertify-cancel">{{cancel}}</a>'
            },
            input: '<input type="text" class="alertify-text" id="alertify-text">',
            message: '<p class="alertify-message">{{message}}</p>',
            log: '<article class="alertify-log{{class}}">{{message}}</article>'
        }, m = function(t) {
            return E.getElementById(t)
        }, {
            alert: function(t, e) {
                return n.dialog(t, "alert", e), this
            },
            confirm: function(t, e) {
                return n.dialog(t, "confirm", e), this
            },
            extend: (n = {
                labels: {
                    ok: "Aceptar",
                    cancel: "Cancelar"
                },
                delay: 8e3,
                addListeners: function(e) {
                    var i, n, a, s, o, r = m("alertify-resetFocus"),
                        l = m("alertify-ok") || k,
                        c = m("alertify-cancel") || k,
                        f = m("alertify-text") || k,
                        u = m("alertify-form") || k,
                        d = void 0 !== l,
                        y = void 0 !== c,
                        b = void 0 !== f,
                        p = "",
                        h = this;
                    i = function(t) {
                        void 0 !== t.preventDefault && t.preventDefault(), a(t), void 0 !== f && (p = f.value), "function" == typeof e && e(!0, p)
                    }, n = function(t) {
                        void 0 !== t.preventDefault && t.preventDefault(), a(t), "function" == typeof e && e(!1)
                    }, a = function(t) {
                        h.hide(), h.unbind(E.body, "keyup", s), h.unbind(r, "focus", o), b && h.unbind(u, "submit", i), d && h.unbind(l, "click", i), y && h.unbind(c, "click", n)
                    }, s = function(t) {
                        var e = t.keyCode;
                        e !== g || b || i(t), e === v && y && n(t)
                    }, o = function(t) {
                        b ? f.focus() : y ? c.focus() : l.focus()
                    }, this.bind(r, "focus", o), d && this.bind(l, "click", i), y && this.bind(c, "click", n), this.bind(E.body, "keyup", s), b && this.bind(u, "submit", i), t.setTimeout(function() {
                        f ? (f.focus(), f.select()) : l.focus()
                    }, 50)
                },
                bind: function(t, e, i) {
                    "function" == typeof t.addEventListener ? t.addEventListener(e, i, !1) : t.attachEvent && t.attachEvent("on" + e, i)
                },
                build: function(t) {
                    var e = "",
                        i = t.type,
                        n = t.message;
                    switch (e += '<div class="alertify-dialog">', "prompt" === i && (e += '<form id="alertify-form">'), e += '<article class="alertify-inner">', e += l.message.replace("{{message}}", n), "prompt" === i && (e += l.input), e += l.buttons.holder, e += "</article>", "prompt" === i && (e += "</form>"), e += '<a id="alertify-resetFocus" class="alertify-resetFocus" href="#">Reset Focus</a>', e += "</div>", i) {
                        case "confirm":
                            e = (e = e.replace("{{buttons}}", l.buttons.ok + l.buttons.cancel)).replace("{{ok}}", this.labels.ok).replace("{{cancel}}", this.labels.cancel);
                            break;
                        case "prompt":
                            e = (e = e.replace("{{buttons}}", l.buttons.submit + l.buttons.cancel)).replace("{{ok}}", this.labels.ok).replace("{{cancel}}", this.labels.cancel);
                            break;
                        case "alert":
                            e = (e = e.replace("{{buttons}}", l.buttons.ok)).replace("{{ok}}", this.labels.ok)
                    }
                    return o.className = "alertify alertify-show alertify-" + i, a.className = "alertify-cover", e
                },
                close: function(t, e) {
                    var i = e && !isNaN(e) ? +e : this.delay;
                    this.bind(t, "click", function() {
                        r.removeChild(t)
                    }), setTimeout(function() {
                        void 0 !== t && t.parentNode === r && r.removeChild(t)
                    }, i)
                },
                dialog: function(t, e, i, n) {
                    s = E.activeElement;
                    var a = function() {
                        o && null !== o.scrollTop || a()
                    };
                    if ("string" != typeof t) throw new Error("message must be a string");
                    if ("string" != typeof e) throw new Error("type must be a string");
                    if (void 0 !== i && "function" != typeof i) throw new Error("fn must be a function");
                    return "function" == typeof this.init && (this.init(), a()), f.push({
                        type: e,
                        message: t,
                        callback: i,
                        placeholder: n
                    }), c || this.setup(), this
                },
                extend: function(i) {
                    return function(t, e) {
                        this.log(t, i, e)
                    }
                },
                hide: function() {
                    f.splice(0, 1), 0 < f.length ? this.setup() : (c = !1, o.className = "alertify alertify-hide alertify-hidden", a.className = "alertify-cover alertify-hidden", s.focus())
                },
                init: function() {
                    E.createElement("nav"), E.createElement("article"), E.createElement("section"), (a = E.createElement("div")).setAttribute("id", "alertify-cover"), a.className = "alertify-cover alertify-hidden", E.body.appendChild(a), (o = E.createElement("section")).setAttribute("id", "alertify"), o.className = "alertify alertify-hidden", E.body.appendChild(o), (r = E.createElement("section")).setAttribute("id", "alertify-logs"), r.className = "alertify-logs", E.body.appendChild(r), E.body.setAttribute("tabindex", "0"), delete this.init
                },
                log: function(t, e, i) {
                    var n = function() {
                        r && null !== r.scrollTop || n()
                    };
                    return "function" == typeof this.init && (this.init(), n()), this.notify(t, e, i), this
                },
                notify: function(t, e, i) {
                    var n = E.createElement("article");
                    n.className = "alertify-log" + ("string" == typeof e && "" !== e ? " alertify-log-" + e : ""), n.innerHTML = t, r.insertBefore(n, r.firstChild), setTimeout(function() {
                        n.className = n.className + " alertify-log-show"
                    }, 50), this.close(n, i)
                },
                set: function(t) {
                    var e;
                    if ("object" != typeof t && t instanceof Array) throw new Error("args must be an object");
                    for (e in t) t.hasOwnProperty(e) && (this[e] = t[e])
                },
                setup: function() {
                    var t = f[0];
                    c = !0, o.innerHTML = this.build(t), "string" == typeof t.placeholder && (m("alertify-text").value = t.placeholder), this.addListeners(t.callback)
                },
                unbind: function(t, e, i) {
                    "function" == typeof t.removeEventListener ? t.removeEventListener(e, i, !1) : t.detachEvent && t.detachEvent("on" + e, i)
                }
            }).extend,
            init: n.init,
            log: function(t, e, i) {
                return n.log(t, e, i), this
            },
            prompt: function(t, e, i) {
                return n.dialog(t, "prompt", e, i), this
            },
            success: function(t, e) {
                return n.log(t, "success", e), this
            },
            error: function(t, e) {
                return n.log(t, "error", e), this
            },
            set: function(t) {
                n.set(t)
            },
            labels: n.labels
        }
    }, "function" == typeof define ? define([], function() {
        return new e
    }) : void 0 === t.alertify && (t.alertify = new e)
}(this);