! function(m) {
	"use strict";
	m.jscroll = {
		defaults: {
			debug: !1,
			autoTrigger: !0,
			autoTriggerUntil: !1,
			loadingHtml: "<small>Loading...</small>",
			loadingFunction: !1,
			padding: 0,
			nextSelector: "a:last",
			contentSelector: "",
			pagingSelector: "",
			callback: !1
		}
	};
	var l = function(a, t) {
		var n, e = a.data("jscroll"),
			l = "function" == typeof t ? {
				callback: t
			} : t,
			s = m.extend({}, m.jscroll.defaults, l, e || {}),
			d = "visible" === a.css("overflow-y"),
			o = a.find(s.nextSelector).first(),
			r = m(window),
			i = m("body"),
			f = d ? r : a,
			c = m.trim(o.prop("href") + " " + s.contentSelector),
			g = function() {
				a.find(".jscroll-inner").length || a.contents().wrapAll('<div class="jscroll-inner" />')
			},
			u = function(t) {
				s.pagingSelector ? t.closest(s.pagingSelector).hide() : t.parent().not(".jscroll-inner,.jscroll-added").addClass("jscroll-next-parent").hide().length || t.wrap('<div class="jscroll-next-parent" />').parent().hide()
			},
			p = function() {
				return f.unbind(".jscroll").removeData("jscroll").find(".jscroll-inner").children().unwrap().filter(".jscroll-added").children().unwrap()
			},
			j = function() {
				if (a.is(":visible")) {
					g();
					var t = a.find("div.jscroll-inner").first(),
						n = a.data("jscroll"),
						e = parseInt(a.css("borderTopWidth"), 10),
						l = isNaN(e) ? 0 : e,
						o = parseInt(a.css("paddingTop"), 10) + l,
						r = d ? f.scrollTop() : a.offset().top,
						i = t.length ? t.offset().top : 0,
						c = Math.ceil(r - i + f.height() + o);
					if (!n.waiting && c + s.padding >= t.outerHeight()) return b("info", "jScroll:", t.outerHeight() - c, "from bottom. Loading next request..."), v()
				}
			},
			h = function() {
				var t = a.find(s.nextSelector).first();
				if (t.length)
					if (s.autoTrigger && (!1 === s.autoTriggerUntil || 0 < s.autoTriggerUntil)) {
						u(t);
						var n = i.height() - a.offset().top;
						(a.height() < n ? a.height() : n) <= (0 < a.offset().top - r.scrollTop() ? r.height() - (a.offset().top - m(window).scrollTop()) : r.height()) && j(), f.unbind(".jscroll").bind("scroll.jscroll", function() {
							return j()
						}), 0 < s.autoTriggerUntil && s.autoTriggerUntil--
					} else f.unbind(".jscroll"), t.bind("click.jscroll", function() {
						return u(t), v(), !1
					})
			},
			v = function() {
				var t = a.find("div.jscroll-inner").first(),
					r = a.data("jscroll");
				return r.waiting = !0, t.prepend('<div class="jscroll-added" />').children(".jscroll-added").first().html('<div class="jscroll-loading" id="jscroll-loading">' + s.loadingHtml + "</div>").promise().done(function() {
					s.loadingFunction && s.loadingFunction()
				}), a.animate({
				// 	scrollTop: t.outerHeight()
				}, 0, function() {
					var o = r.nextHref;
					t.find("div.jscroll-added").last().load(o, function(t, n) {
						if ("error" === n) return p();
						var e, l = m(this).find(s.nextSelector).first();
						r.waiting = !1, r.nextHref = !!l.prop("href") && m.trim(l.prop("href") + " " + s.contentSelector), m(".jscroll-next-parent", a).remove(), (e = e || a.data("jscroll")) && e.nextHref ? h() : (b("warn", "jScroll: nextSelector not found - destroying"), p()), s.callback && s.callback.call(this, o), b("dir", r)
					})
				})
			},
			b = function(t) {
				if (s.debug && "object" == typeof console && ("object" == typeof t || "function" == typeof console[t]))
					if ("object" == typeof t) {
						var n = [];
						for (var e in t) "function" == typeof console[e] ? (n = t[e].length ? t[e] : [t[e]], console[e].apply(console, n)) : console.log.apply(console, n)
					} else console[t].apply(console, Array.prototype.slice.call(arguments, 1))
			};
		return a.data("jscroll", m.extend({}, e, {
			initialized: !0,
			waiting: !1,
			nextHref: c
		})), g(), (n = m(s.loadingHtml).filter("img").attr("src")) && ((new Image).src = n), h(), m.extend(a.jscroll, {
			destroy: p
		}), a
	};
	m.fn.jscroll = function(e) {
		return this.each(function() {
			var t = m(this),
				n = t.data("jscroll");
			n && n.initialized || l(t, e)
		})
	}
}(jQuery);