if (!window['googleLT_']) {
    window['googleLT_'] = (new Date()).getTime();
}
if (!window['google']) {
    window['google'] = {};
}
if (!window['google']['loader']) {
    window['google']['loader'] = {};
    google.loader.ServiceBase = 'https://www.google.com/uds';
    google.loader.GoogleApisBase = 'https://ajax.googleapis.com/ajax';
    google.loader.ApiKey = 'notsupplied';
    google.loader.KeyVerified = true;
    google.loader.LoadFailure = true;
    google.loader.Secure = true;
    google.loader.GoogleLocale = 'www.google.com';
    google.loader.ClientLocation = null;
    google.loader.AdditionalParams = '';
    (function() {
        function g(a) {
            return a in l ? l[a] : l[a] = -1 != navigator.userAgent.toLowerCase().indexOf(a)
        }
        var l = {};

        function m(a, b) {
            var c = function() {};
            c.prototype = b.prototype;
            a.ca = b.prototype;
            a.prototype = new c
        }

        function n(a, b, c) {
            var d = Array.prototype.slice.call(arguments, 2) || [];
            return function() {
                return a.apply(b, d.concat(Array.prototype.slice.call(arguments)))
            }
        }

        function p(a) {
            a = Error(a);
            a.toString = function() {
                return this.message
            };
            return a
        }

        function q(a, b) {
            for (var c = a.split(/\./), d = window, e = 0; e < c.length - 1; e++) d[c[e]] || (d[c[e]] = {}), d = d[c[e]];
            d[c[c.length - 1]] = b
        }

        function r(a, b, c) {
            a[b] = c
        }
        if (!t) var t = q;
        if (!u) var u = r;
        google.loader.F = {};
        t("google.loader.callbacks", google.loader.F);
        var v = {},
            w = {};
        google.loader.eval = {};
        t("google.loader.eval", google.loader.eval);
        google.load = function(a, b, c) {
            function d(a) {
                var b = a.split(".");
                if (2 < b.length) throw p("Module: '" + a + "' not found!");
                "undefined" != typeof b[1] && (e = b[0], c.packages = c.packages || [], c.packages.push(b[1]))
            }
            var e = a;
            c = c || {};
            if (a instanceof Array || a && "object" == typeof a && "function" == typeof a.join && "function" == typeof a.reverse)
                for (var f = 0; f < a.length; f++) d(a[f]);
            else d(a);
            if (a = v[":" + e]) {
                c && !c.language && c.locale && (c.language = c.locale);
                c && "string" == typeof c.callback && (f = c.callback, f.match(/^[[\]A-Za-z0-9._]+$/) && (f =
                    window.eval(f), c.callback = f));
                if ((f = c && null != c.callback) && !a.D(b)) throw p("Module: '" + e + "' must be loaded before DOM onLoad!");
                f ? a.u(b, c) ? window.setTimeout(c.callback, 0) : a.load(b, c) : a.u(b, c) || a.load(b, c)
            } else throw p("Module: '" + e + "' not found!");
        };
        t("google.load", google.load);
        google.ba = function(a, b) {
            b ? (0 == x.length && (y(window, "load", z), !g("msie") && !g("safari") && !g("konqueror") && g("mozilla") || window.opera ? window.addEventListener("DOMContentLoaded", z, !1) : g("msie") ? document.write("<script defer onreadystatechange='google.loader.domReady()' src=//:>\x3c/script>") : (g("safari") || g("konqueror")) && window.setTimeout(B, 10)), x.push(a)) : y(window, "load", a)
        };
        t("google.setOnLoadCallback", google.ba);

        function y(a, b, c) {
            if (a.addEventListener) a.addEventListener(b, c, !1);
            else if (a.attachEvent) a.attachEvent("on" + b, c);
            else {
                var d = a["on" + b];
                a["on" + b] = null != d ? C([c, d]) : c
            }
        }

        function C(a) {
            return function() {
                for (var b = 0; b < a.length; b++) a[b]()
            }
        }
        var x = [];
        google.loader.W = function() {
            var a = window.event.srcElement;
            "complete" == a.readyState && (a.onreadystatechange = null, a.parentNode.removeChild(a), z())
        };
        t("google.loader.domReady", google.loader.W);
        var D = {
            loaded: !0,
            complete: !0
        };

        function B() {
            D[document.readyState] ? z() : 0 < x.length && window.setTimeout(B, 10)
        }

        function z() {
            for (var a = 0; a < x.length; a++) x[a]();
            x.length = 0
        }
        google.loader.f = function(a, b, c) {
            if (c) {
                var d;
                "script" == a ? (d = document.createElement("script"), d.type = "text/javascript", d.src = b) : "css" == a && (d = document.createElement("link"), d.type = "text/css", d.href = b, d.rel = "stylesheet");
                (a = document.getElementsByTagName("head")[0]) || (a = document.body.parentNode.appendChild(document.createElement("head")));
                a.appendChild(d)
            } else "script" == a ? document.write('<script src="' + b + '" type="text/javascript">\x3c/script>') : "css" == a && document.write('<link href="' + b + '" type="text/css" rel="stylesheet"></link>')
        };
        t("google.loader.writeLoadTag", google.loader.f);
        google.loader.Z = function(a) {
            w = a
        };
        t("google.loader.rfm", google.loader.Z);
        google.loader.aa = function(a) {
            for (var b in a) "string" == typeof b && b && ":" == b.charAt(0) && !v[b] && (v[b] = new E(b.substring(1), a[b]))
        };
        t("google.loader.rpl", google.loader.aa);
        google.loader.$ = function(a) {
            if ((a = a.specs) && a.length)
                for (var b = 0; b < a.length; ++b) {
                    var c = a[b];
                    "string" == typeof c ? v[":" + c] = new F(c) : (c = new G(c.name, c.baseSpec, c.customSpecs), v[":" + c.name] = c)
                }
        };
        t("google.loader.rm", google.loader.$);
        google.loader.loaded = function(a) {
            v[":" + a.module].o(a)
        };
        t("google.loader.loaded", google.loader.loaded);
        google.loader.V = function() {
            return "qid=" + ((new Date).getTime().toString(16) + Math.floor(1E7 * Math.random()).toString(16))
        };
        t("google.loader.createGuidArg_", google.loader.V);
        q("google_exportSymbol", q);
        q("google_exportProperty", r);
        google.loader.a = {};
        t("google.loader.themes", google.loader.a);
        google.loader.a.K = "//www.google.com/cse/style/look/bubblegum.css";
        u(google.loader.a, "BUBBLEGUM", google.loader.a.K);
        google.loader.a.M = "//www.google.com/cse/style/look/greensky.css";
        u(google.loader.a, "GREENSKY", google.loader.a.M);
        google.loader.a.L = "//www.google.com/cse/style/look/espresso.css";
        u(google.loader.a, "ESPRESSO", google.loader.a.L);
        google.loader.a.O = "//www.google.com/cse/style/look/shiny.css";
        u(google.loader.a, "SHINY", google.loader.a.O);
        google.loader.a.N = "//www.google.com/cse/style/look/minimalist.css";
        u(google.loader.a, "MINIMALIST", google.loader.a.N);
        google.loader.a.P = "//www.google.com/cse/style/look/v2/default.css";
        u(google.loader.a, "V2_DEFAULT", google.loader.a.P);

        function F(a) {
            this.b = a;
            this.B = [];
            this.A = {};
            this.l = {};
            this.g = {};
            this.s = !0;
            this.c = -1
        }
        F.prototype.i = function(a, b) {
            var c = "";
            void 0 != b && (void 0 != b.language && (c += "&hl=" + encodeURIComponent(b.language)), void 0 != b.nocss && (c += "&output=" + encodeURIComponent("nocss=" + b.nocss)), void 0 != b.nooldnames && (c += "&nooldnames=" + encodeURIComponent(b.nooldnames)), void 0 != b.packages && (c += "&packages=" + encodeURIComponent(b.packages)), null != b.callback && (c += "&async=2"), void 0 != b.style && (c += "&style=" + encodeURIComponent(b.style)), void 0 != b.noexp && (c += "&noexp=true"), void 0 != b.other_params && (c += "&" + b.other_params));
            if (!this.s) {
                google[this.b] && google[this.b].JSHash && (c += "&sig=" + encodeURIComponent(google[this.b].JSHash));
                var d = [],
                    e;
                for (e in this.A) ":" == e.charAt(0) && d.push(e.substring(1));
                for (e in this.l) ":" == e.charAt(0) && this.l[e] && d.push(e.substring(1));
                c += "&have=" + encodeURIComponent(d.join(","))
            }
            return google.loader.ServiceBase + "/?file=" + this.b + "&v=" + a + google.loader.AdditionalParams + c
        };
        F.prototype.H = function(a) {
            var b = null;
            a && (b = a.packages);
            var c = null;
            if (b)
                if ("string" == typeof b) c = [a.packages];
                else if (b.length)
                    for (c = [], a = 0; a < b.length; a++) "string" == typeof b[a] && c.push(b[a].replace(/^\s*|\s*$/, "").toLowerCase());
            c || (c = ["default"]);
            b = [];
            for (a = 0; a < c.length; a++) this.A[":" + c[a]] || b.push(c[a]);
            return b
        };
        F.prototype.load = function(a, b) {
            var c = this.H(b),
                d = b && null != b.callback;
            if (d) var e = new H(b.callback);
            for (var f = [], h = c.length - 1; 0 <= h; h--) {
                var k = c[h];
                d && e.R(k);
                this.l[":" + k] ? (c.splice(h, 1), d && this.g[":" + k].push(e)) : f.push(k)
            }
            if (c.length) {
                b && b.packages && (b.packages = c.sort().join(","));
                for (h = 0; h < f.length; h++) k = f[h], this.g[":" + k] = [], d && this.g[":" + k].push(e);
                if (b || null == w[":" + this.b] || null == w[":" + this.b].versions[":" + a] || google.loader.AdditionalParams || !this.s) b && b.autoloaded || google.loader.f("script", this.i(a,
                    b), d);
                else {
                    c = w[":" + this.b];
                    google[this.b] = google[this.b] || {};
                    for (var A in c.properties) A && ":" == A.charAt(0) && (google[this.b][A.substring(1)] = c.properties[A]);
                    google.loader.f("script", google.loader.ServiceBase + c.path + c.js, d);
                    c.css && google.loader.f("css", google.loader.ServiceBase + c.path + c.css, d)
                }
                this.s && (this.s = !1, this.c = (new Date).getTime(), 1 != this.c % 100 && (this.c = -1));
                for (h = 0; h < f.length; h++) k = f[h], this.l[":" + k] = !0
            }
        };
        F.prototype.o = function(a) {
            -1 != this.c && (I("al_" + this.b, "jl." + ((new Date).getTime() - this.c), !0), this.c = -1);
            this.B = this.B.concat(a.components);
            google.loader[this.b] || (google.loader[this.b] = {});
            google.loader[this.b].packages = this.B.slice(0);
            for (var b = 0; b < a.components.length; b++) {
                this.A[":" + a.components[b]] = !0;
                this.l[":" + a.components[b]] = !1;
                var c = this.g[":" + a.components[b]];
                if (c) {
                    for (var d = 0; d < c.length; d++) c[d].U(a.components[b]);
                    delete this.g[":" + a.components[b]]
                }
            }
        };
        F.prototype.u = function(a, b) {
            return 0 == this.H(b).length
        };
        F.prototype.D = function() {
            return !0
        };

        function H(a) {
            this.T = a;
            this.v = {};
            this.C = 0
        }
        H.prototype.R = function(a) {
            this.C++;
            this.v[":" + a] = !0
        };
        H.prototype.U = function(a) {
            this.v[":" + a] && (this.v[":" + a] = !1, this.C--, 0 == this.C && window.setTimeout(this.T, 0))
        };

        function G(a, b, c) {
            this.name = a;
            this.S = b;
            this.w = c;
            this.G = this.j = !1;
            this.m = [];
            google.loader.F[this.name] = n(this.o, this)
        }
        m(G, F);
        G.prototype.load = function(a, b) {
            var c = b && null != b.callback;
            c ? (this.m.push(b.callback), b.callback = "google.loader.callbacks." + this.name) : this.j = !0;
            b && b.autoloaded || google.loader.f("script", this.i(a, b), c)
        };
        G.prototype.u = function(a, b) {
            return b && null != b.callback ? this.G : this.j
        };
        G.prototype.o = function() {
            this.G = !0;
            for (var a = 0; a < this.m.length; a++) window.setTimeout(this.m[a], 0);
            this.m = []
        };
        var J = function(a, b) {
            return a.string ? encodeURIComponent(a.string) + "=" + encodeURIComponent(b) : a.regex ? b.replace(/(^.*$)/, a.regex) : ""
        };
        G.prototype.i = function(a, b) {
            return this.X(this.I(a), a, b)
        };
        G.prototype.X = function(a, b, c) {
            var d = "";
            a.key && (d += "&" + J(a.key, google.loader.ApiKey));
            a.version && (d += "&" + J(a.version, b));
            b = google.loader.Secure && a.ssl ? a.ssl : a.uri;
            if (null != c)
                for (var e in c) a.params[e] ? d += "&" + J(a.params[e], c[e]) : "other_params" == e ? d += "&" + c[e] : "base_domain" == e && (b = "http://" + c[e] + a.uri.substring(a.uri.indexOf("/", 7)));
            google[this.name] = {}; - 1 == b.indexOf("?") && d && (d = "?" + d.substring(1));
            return b + d
        };
        G.prototype.D = function(a) {
            return this.I(a).deferred
        };
        G.prototype.I = function(a) {
            if (this.w)
                for (var b = 0; b < this.w.length; ++b) {
                    var c = this.w[b];
                    if ((new RegExp(c.pattern)).test(a)) return c
                }
            return this.S
        };

        function E(a, b) {
            this.b = a;
            this.h = b;
            this.j = !1
        }
        m(E, F);
        E.prototype.load = function(a, b) {
            this.j = !0;
            google.loader.f("script", this.i(a, b), !1)
        };
        E.prototype.u = function() {
            return this.j
        };
        E.prototype.o = function() {};
        E.prototype.i = function(a, b) {
            if (!this.h.versions[":" + a]) {
                if (this.h.aliases) {
                    var c = this.h.aliases[":" + a];
                    c && (a = c)
                }
                if (!this.h.versions[":" + a]) throw p("Module: '" + this.b + "' with version '" + a + "' not found!");
            }
            return google.loader.GoogleApisBase + "/libs/" + this.b + "/" + a + "/" + this.h.versions[":" + a][b && b.uncompressed ? "uncompressed" : "compressed"]
        };
        E.prototype.D = function() {
            return !1
        };
        var K = !1,
            L = [],
            M = (new Date).getTime(),
            O = function() {
                K || (y(window, "unload", N), K = !0)
            },
            Q = function(a, b) {
                O();
                if (!(google.loader.Secure || google.loader.Options && !1 !== google.loader.Options.csi)) {
                    for (var c = 0; c < a.length; c++) a[c] = encodeURIComponent(a[c].toLowerCase().replace(/[^a-z0-9_.]+/g, "_"));
                    for (c = 0; c < b.length; c++) b[c] = encodeURIComponent(b[c].toLowerCase().replace(/[^a-z0-9_.]+/g, "_"));
                    window.setTimeout(n(P, null, "//gg.google.com/csi?s=uds&v=2&action=" + a.join(",") + "&it=" + b.join(",")), 1E4)
                }
            },
            I = function(a, b,
                         c) {
                c ? Q([a], [b]) : (O(), L.push("r" + L.length + "=" + encodeURIComponent(a + (b ? "|" + b : ""))), window.setTimeout(N, 5 < L.length ? 0 : 15E3))
            },
            N = function() {
                if (L.length) {
                    var a = google.loader.ServiceBase;
                    0 == a.indexOf("http:") && (a = a.replace(/^http:/, "https:"));
                    P(a + "/stats?" + L.join("&") + "&nc=" + (new Date).getTime() + "_" + ((new Date).getTime() - M));
                    L.length = 0
                }
            },
            P = function(a) {
                var b = new Image,
                    c = P.Y++;
                P.J[c] = b;
                b.onload = b.onerror = function() {
                    delete P.J[c]
                };
                b.src = a;
                b = null
            };
        P.J = {};
        P.Y = 0;
        q("google.loader.recordCsiStat", Q);
        q("google.loader.recordStat", I);
        q("google.loader.createImageForLogging", P);

    })();
    google.loader.rm({
        "specs": ["visualization", "payments", {
            "name": "annotations",
            "baseSpec": {
                "uri": "http://www.google.com/reviews/scripts/annotations_bootstrap.js",
                "ssl": null,
                "key": {
                    "string": "key"
                },
                "version": {
                    "string": "v"
                },
                "deferred": true,
                "params": {
                    "country": {
                        "string": "gl"
                    },
                    "callback": {
                        "string": "callback"
                    },
                    "language": {
                        "string": "hl"
                    }
                }
            }
        }, "language", "gdata", "wave", "spreadsheets", "search", "orkut", "feeds", "annotations_v2", "picker", "identitytoolkit", {
            "name": "maps",
            "baseSpec": {
                "uri": "http://maps.google.com/maps?file\u003dgoogleapi",
                "ssl": "https://maps-api-ssl.google.com/maps?file\u003dgoogleapi",
                "key": {
                    "string": "key"
                },
                "version": {
                    "string": "v"
                },
                "deferred": true,
                "params": {
                    "callback": {
                        "regex": "callback\u003d$1\u0026async\u003d2"
                    },
                    "language": {
                        "string": "hl"
                    }
                }
            },
            "customSpecs": [{
                "uri": "http://maps.googleapis.com/maps/api/js",
                "ssl": "https://maps.googleapis.com/maps/api/js",
                "version": {
                    "string": "v"
                },
                "deferred": true,
                "params": {
                    "callback": {
                        "string": "callback"
                    },
                    "language": {
                        "string": "hl"
                    }
                },
                "pattern": "^(3|3..*)$"
            }]
        }, {
            "name": "friendconnect",
            "baseSpec": {
                "uri": "http://www.google.com/friendconnect/script/friendconnect.js",
                "ssl": "https://www.google.com/friendconnect/script/friendconnect.js",
                "key": {
                    "string": "key"
                },
                "version": {
                    "string": "v"
                },
                "deferred": false,
                "params": {}
            }
        }, {
            "name": "sharing",
            "baseSpec": {
                "uri": "http://www.google.com/s2/sharing/js",
                "ssl": null,
                "key": {
                    "string": "key"
                },
                "version": {
                    "string": "v"
                },
                "deferred": false,
                "params": {
                    "language": {
                        "string": "hl"
                    }
                }
            }
        }, "ads", {
            "name": "books",
            "baseSpec": {
                "uri": "http://books.google.com/books/api.js",
                "ssl": "https://encrypted.google.com/books/api.js",
                "key": {
                    "string": "key"
                },
                "version": {
                    "string": "v"
                },
                "deferred": true,
                "params": {
                    "callback": {
                        "string": "callback"
                    },
                    "language": {
                        "string": "hl"
                    }
                }
            }
        }, "elements", "earth", "ima"]
    });
    google.loader.rfm({
        ":search": {
            "versions": {
                ":1": "1",
                ":1.0": "1"
            },
            "path": "/api/search/1.0/8bdfc79787aa2b2b1ac464140255872c/",
            "js": "default+en.I.js",
            "css": "default+en.css",
            "properties": {
                ":Version": "1.0",
                ":NoOldNames": false,
                ":JSHash": "8bdfc79787aa2b2b1ac464140255872c"
            }
        },
        ":language": {
            "versions": {
                ":1": "1",
                ":1.0": "1"
            },
            "path": "/api/language/1.0/21ed3320451b9198aa71e398186af717/",
            "js": "default+en.I.js",
            "properties": {
                ":Version": "1.0",
                ":JSHash": "21ed3320451b9198aa71e398186af717"
            }
        },
        ":annotations": {
            "versions": {
                ":1": "1",
                ":1.0": "1"
            },
            "path": "/api/annotations/1.0/3b0f18d6e7bf8cf053640179ef6d98d1/",
            "js": "default+en.I.js",
            "properties": {
                ":Version": "1.0",
                ":JSHash": "3b0f18d6e7bf8cf053640179ef6d98d1"
            }
        },
        ":wave": {
            "versions": {
                ":1": "1",
                ":1.0": "1"
            },
            "path": "/api/wave/1.0/3b6f7573ff78da6602dda5e09c9025bf/",
            "js": "default.I.js",
            "properties": {
                ":Version": "1.0",
                ":JSHash": "3b6f7573ff78da6602dda5e09c9025bf"
            }
        },
        ":earth": {
            "versions": {
                ":1": "1",
                ":1.0": "1"
            },
            "path": "/api/earth/1.0/d2fd21686addcd75dd267a0ff2f7b381/",
            "js": "default.I.js",
            "properties": {
                ":Version": "1.0",
                ":JSHash": "d2fd21686addcd75dd267a0ff2f7b381"
            }
        },
        ":feeds": {
            "versions": {
                ":1": "1",
                ":1.0": "1"
            },
            "path": "/api/feeds/1.0/482f2817cdf8982edf2e5669f9e3a627/",
            "js": "default+en.I.js",
            "css": "default+en.css",
            "properties": {
                ":Version": "1.0",
                ":JSHash": "482f2817cdf8982edf2e5669f9e3a627"
            }
        },
        ":picker": {
            "versions": {
                ":1": "1",
                ":1.0": "1"
            },
            "path": "/api/picker/1.0/1c635e91b9d0c082c660a42091913907/",
            "js": "default.I.js",
            "css": "default.css",
            "properties": {
                ":Version": "1.0",
                ":JSHash": "1c635e91b9d0c082c660a42091913907"
            }
        },
        ":ima": {
            "versions": {
                ":3": "1",
                ":3.0": "1"
            },
            "path": "/api/ima/3.0/28a914332232c9a8ac0ae8da68b1006e/",
            "js": "default.I.js",
            "properties": {
                ":Version": "3.0",
                ":JSHash": "28a914332232c9a8ac0ae8da68b1006e"
            }
        }
    });
    google.loader.rpl({
        ":swfobject": {
            "versions": {
                ":2.1": {
                    "uncompressed": "swfobject_src.js",
                    "compressed": "swfobject.js"
                },
                ":2.2": {
                    "uncompressed": "swfobject_src.js",
                    "compressed": "swfobject.js"
                }
            },
            "aliases": {
                ":2": "2.2"
            }
        },
        ":chrome-frame": {
            "versions": {
                ":1.0.0": {
                    "uncompressed": "CFInstall.js",
                    "compressed": "CFInstall.min.js"
                },
                ":1.0.1": {
                    "uncompressed": "CFInstall.js",
                    "compressed": "CFInstall.min.js"
                },
                ":1.0.2": {
                    "uncompressed": "CFInstall.js",
                    "compressed": "CFInstall.min.js"
                }
            },
            "aliases": {
                ":1": "1.0.2",
                ":1.0": "1.0.2"
            }
        },
        ":ext-core": {
            "versions": {
                ":3.1.0": {
                    "uncompressed": "ext-core-debug.js",
                    "compressed": "ext-core.js"
                },
                ":3.0.0": {
                    "uncompressed": "ext-core-debug.js",
                    "compressed": "ext-core.js"
                }
            },
            "aliases": {
                ":3": "3.1.0",
                ":3.0": "3.0.0",
                ":3.1": "3.1.0"
            }
        },
        ":webfont": {
            "versions": {
                ":1.0.12": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.13": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.14": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.15": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.10": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.11": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.27": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.28": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.29": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.23": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.24": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.25": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.26": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.21": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.22": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.3": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.4": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.5": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.6": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.9": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.16": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.17": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.0": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.18": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.1": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.19": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                },
                ":1.0.2": {
                    "uncompressed": "webfont_debug.js",
                    "compressed": "webfont.js"
                }
            },
            "aliases": {
                ":1": "1.0.29",
                ":1.0": "1.0.29"
            }
        },
        ":scriptaculous": {
            "versions": {
                ":1.8.3": {
                    "uncompressed": "scriptaculous.js",
                    "compressed": "scriptaculous.js"
                },
                ":1.9.0": {
                    "uncompressed": "scriptaculous.js",
                    "compressed": "scriptaculous.js"
                },
                ":1.8.1": {
                    "uncompressed": "scriptaculous.js",
                    "compressed": "scriptaculous.js"
                },
                ":1.8.2": {
                    "uncompressed": "scriptaculous.js",
                    "compressed": "scriptaculous.js"
                }
            },
            "aliases": {
                ":1": "1.9.0",
                ":1.8": "1.8.3",
                ":1.9": "1.9.0"
            }
        },
        ":jqueryui": {
            "versions": {
                ":1.8.17": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.8.16": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.8.15": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.8.14": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.8.4": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.8.13": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.8.5": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.8.12": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.8.6": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.8.11": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.8.7": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.8.10": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.8.8": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.8.9": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.6.0": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.7.0": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.5.2": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.8.0": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.7.1": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.5.3": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.8.1": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.7.2": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.8.2": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                },
                ":1.7.3": {
                    "uncompressed": "jquery-ui.js",
                    "compressed": "jquery-ui.min.js"
                }
            },
            "aliases": {
                ":1": "1.8.17",
                ":1.8.3": "1.8.4",
                ":1.5": "1.5.3",
                ":1.6": "1.6.0",
                ":1.7": "1.7.3",
                ":1.8": "1.8.17"
            }
        },
        ":mootools": {
            "versions": {
                ":1.3.0": {
                    "uncompressed": "mootools.js",
                    "compressed": "mootools-yui-compressed.js"
                },
                ":1.2.1": {
                    "uncompressed": "mootools.js",
                    "compressed": "mootools-yui-compressed.js"
                },
                ":1.1.2": {
                    "uncompressed": "mootools.js",
                    "compressed": "mootools-yui-compressed.js"
                },
                ":1.4.0": {
                    "uncompressed": "mootools.js",
                    "compressed": "mootools-yui-compressed.js"
                },
                ":1.3.1": {
                    "uncompressed": "mootools.js",
                    "compressed": "mootools-yui-compressed.js"
                },
                ":1.2.2": {
                    "uncompressed": "mootools.js",
                    "compressed": "mootools-yui-compressed.js"
                },
                ":1.4.1": {
                    "uncompressed": "mootools.js",
                    "compressed": "mootools-yui-compressed.js"
                },
                ":1.3.2": {
                    "uncompressed": "mootools.js",
                    "compressed": "mootools-yui-compressed.js"
                },
                ":1.2.3": {
                    "uncompressed": "mootools.js",
                    "compressed": "mootools-yui-compressed.js"
                },
                ":1.4.2": {
                    "uncompressed": "mootools.js",
                    "compressed": "mootools-yui-compressed.js"
                },
                ":1.2.4": {
                    "uncompressed": "mootools.js",
                    "compressed": "mootools-yui-compressed.js"
                },
                ":1.2.5": {
                    "uncompressed": "mootools.js",
                    "compressed": "mootools-yui-compressed.js"
                },
                ":1.1.1": {
                    "uncompressed": "mootools.js",
                    "compressed": "mootools-yui-compressed.js"
                }
            },
            "aliases": {
                ":1": "1.1.2",
                ":1.1": "1.1.2",
                ":1.2": "1.2.5",
                ":1.3": "1.3.2",
                ":1.4": "1.4.2",
                ":1.11": "1.1.1"
            }
        },
        ":yui": {
            "versions": {
                ":2.8.0r4": {
                    "uncompressed": "build/yuiloader/yuiloader.js",
                    "compressed": "build/yuiloader/yuiloader-min.js"
                },
                ":2.9.0": {
                    "uncompressed": "build/yuiloader/yuiloader.js",
                    "compressed": "build/yuiloader/yuiloader-min.js"
                },
                ":2.8.1": {
                    "uncompressed": "build/yuiloader/yuiloader.js",
                    "compressed": "build/yuiloader/yuiloader-min.js"
                },
                ":2.6.0": {
                    "uncompressed": "build/yuiloader/yuiloader.js",
                    "compressed": "build/yuiloader/yuiloader-min.js"
                },
                ":2.7.0": {
                    "uncompressed": "build/yuiloader/yuiloader.js",
                    "compressed": "build/yuiloader/yuiloader-min.js"
                },
                ":3.3.0": {
                    "uncompressed": "build/yui/yui.js",
                    "compressed": "build/yui/yui-min.js"
                },
                ":2.8.2r1": {
                    "uncompressed": "build/yuiloader/yuiloader.js",
                    "compressed": "build/yuiloader/yuiloader-min.js"
                }
            },
            "aliases": {
                ":2": "2.9.0",
                ":3": "3.3.0",
                ":2.8.2": "2.8.2r1",
                ":2.8.0": "2.8.0r4",
                ":3.3": "3.3.0",
                ":2.6": "2.6.0",
                ":2.7": "2.7.0",
                ":2.8": "2.8.2r1",
                ":2.9": "2.9.0"
            }
        },
        ":prototype": {
            "versions": {
                ":1.6.1.0": {
                    "uncompressed": "prototype.js",
                    "compressed": "prototype.js"
                },
                ":1.6.0.2": {
                    "uncompressed": "prototype.js",
                    "compressed": "prototype.js"
                },
                ":1.7.0.0": {
                    "uncompressed": "prototype.js",
                    "compressed": "prototype.js"
                },
                ":1.6.0.3": {
                    "uncompressed": "prototype.js",
                    "compressed": "prototype.js"
                }
            },
            "aliases": {
                ":1": "1.7.0.0",
                ":1.6.0": "1.6.0.3",
                ":1.6.1": "1.6.1.0",
                ":1.7.0": "1.7.0.0",
                ":1.6": "1.6.1.0",
                ":1.7": "1.7.0.0"
            }
        },
        ":jquery": {
            "versions": {
                ":1.3.0": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.4.0": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.3.1": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.5.0": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.4.1": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.3.2": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.2.3": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.6.0": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.5.1": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.4.2": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.7.0": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.6.1": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.5.2": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.4.3": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.7.1": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.6.2": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.4.4": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.2.6": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.6.3": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                },
                ":1.6.4": {
                    "uncompressed": "jquery.js",
                    "compressed": "jquery.min.js"
                }
            },
            "aliases": {
                ":1": "1.7.1",
                ":1.2": "1.2.6",
                ":1.3": "1.3.2",
                ":1.4": "1.4.4",
                ":1.5": "1.5.2",
                ":1.6": "1.6.4",
                ":1.7": "1.7.1"
            }
        },
        ":dojo": {
            "versions": {
                ":1.3.0": {
                    "uncompressed": "dojo/dojo.xd.js.uncompressed.js",
                    "compressed": "dojo/dojo.xd.js"
                },
                ":1.4.0": {
                    "uncompressed": "dojo/dojo.xd.js.uncompressed.js",
                    "compressed": "dojo/dojo.xd.js"
                },
                ":1.3.1": {
                    "uncompressed": "dojo/dojo.xd.js.uncompressed.js",
                    "compressed": "dojo/dojo.xd.js"
                },
                ":1.5.0": {
                    "uncompressed": "dojo/dojo.xd.js.uncompressed.js",
                    "compressed": "dojo/dojo.xd.js"
                },
                ":1.4.1": {
                    "uncompressed": "dojo/dojo.xd.js.uncompressed.js",
                    "compressed": "dojo/dojo.xd.js"
                },
                ":1.3.2": {
                    "uncompressed": "dojo/dojo.xd.js.uncompressed.js",
                    "compressed": "dojo/dojo.xd.js"
                },
                ":1.2.3": {
                    "uncompressed": "dojo/dojo.xd.js.uncompressed.js",
                    "compressed": "dojo/dojo.xd.js"
                },
                ":1.6.0": {
                    "uncompressed": "dojo/dojo.xd.js.uncompressed.js",
                    "compressed": "dojo/dojo.xd.js"
                },
                ":1.5.1": {
                    "uncompressed": "dojo/dojo.xd.js.uncompressed.js",
                    "compressed": "dojo/dojo.xd.js"
                },
                ":1.7.0": {
                    "uncompressed": "dojo/dojo.js.uncompressed.js",
                    "compressed": "dojo/dojo.js"
                },
                ":1.6.1": {
                    "uncompressed": "dojo/dojo.xd.js.uncompressed.js",
                    "compressed": "dojo/dojo.xd.js"
                },
                ":1.4.3": {
                    "uncompressed": "dojo/dojo.xd.js.uncompressed.js",
                    "compressed": "dojo/dojo.xd.js"
                },
                ":1.7.1": {
                    "uncompressed": "dojo/dojo.js.uncompressed.js",
                    "compressed": "dojo/dojo.js"
                },
                ":1.7.2": {
                    "uncompressed": "dojo/dojo.js.uncompressed.js",
                    "compressed": "dojo/dojo.js"
                },
                ":1.2.0": {
                    "uncompressed": "dojo/dojo.xd.js.uncompressed.js",
                    "compressed": "dojo/dojo.xd.js"
                },
                ":1.1.1": {
                    "uncompressed": "dojo/dojo.xd.js.uncompressed.js",
                    "compressed": "dojo/dojo.xd.js"
                }
            },
            "aliases": {
                ":1": "1.6.1",
                ":1.1": "1.1.1",
                ":1.2": "1.2.3",
                ":1.3": "1.3.2",
                ":1.4": "1.4.3",
                ":1.5": "1.5.1",
                ":1.6": "1.6.1",
                ":1.7": "1.7.2"
            }
        }
    });
}