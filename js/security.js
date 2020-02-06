(function (g, d) {
    "function" == typeof define && define.amd ? define([], d) : "object" == typeof exports ? module.exports = d() : g.aes4js = d()
})(this, function () {
    function g(b) {
        return crypto.subtle.digest("SHA-256", (new TextEncoder("utf-8")).encode(b)).then(function (a) {
            return Array.from(new Uint8Array(a)).map(function (a) {
                return ("00" + a.toString(16)).slice(-2)
            }).join("")
        })
    }

    function d(b) {
        return 10 > b.length && (b = b.repeat(12 - b.length)), g("349d" + b + "9d3458694307" + b.length).then(function (a) {
            var e = (new TextEncoder).encode(b), c = (new TextEncoder).encode(a);
            return crypto.subtle.importKey("raw", e, {name: "PBKDF2"}, !1, ["deriveBits", "deriveKey"]).then(function (a) {
                return window.crypto.subtle.deriveKey({
                    name: "PBKDF2",
                    salt: c,
                    iterations: 1e5 + b.length,
                    hash: "SHA-256"
                }, a, {name: "AES-GCM", length: 256}, !0, ["encrypt", "decrypt"])
            })
        })
    }

    function h(b) {
        var a = b.split(/[:;,]/);
        b = a[1], a = ("base64" == a[2] ? atob : decodeURIComponent)(a.pop());
        var e = a.length, c = 0, f = new Uint8Array(e);
        for (c; c < e; ++c) f[c] = a.charCodeAt(c);
        return new Blob([f], {type: b})
    }

    return {
        encrypt: function (b, a) {
            var e = crypto.getRandomValues(new Uint8Array(12)), c = (new TextEncoder("utf-8")).encode(a), f = !1;
            return "object" == typeof a && (c = a, f = !0), d(b).then(function (a) {
                return window.crypto.subtle.encrypt({name: "AES-GCM", iv: e, tagLength: 128}, a, c).then(function (b) {
                    return window.crypto.subtle.exportKey("jwk", a).then(function (a) {
                        return new Promise(function (a, c) {
                            var d = new FileReader;
                            d.onload = function () {
                                a({encrypted: d.result, iv: [].slice.call(e), bin: f})
                            }, d.onerror = c, d.readAsDataURL(new Blob([b]))
                        })
                    })
                })
            })["catch"](console.error)
        }, decrypt: function (b, a) {
            return "string" == typeof a && (a = JSON.parse(a)), d(b).then(function (b) {
                return (new Promise(function (c, d) {
                    var e = h(a.encrypted), f = new FileReader;
                    f.onload = function () {
                        crypto.subtle.decrypt({
                            name: "AES-GCM",
                            iv: new Uint8Array(a.iv),
                            tagLength: 128
                        }, b, f.result).then(function (b) {
                            return a.bin ? b : (new TextDecoder("utf-8")).decode(b)
                        }).then(c)["catch"](function (a) {
                            "OperationError" === String(a) && (a = "Opps!\r\n\r\nWrong Password, try again."), d(a)
                        })
                    }, f.readAsArrayBuffer(e)
                }))["catch"](function (a) {
                    throw a
                })
            })
        }
    }
})


function generateKey(salt, pwd) {

}

function encode5(key, password) {

    aes4js.encrypt("123", "hello world") // encrypt with password 123
    // .then(aes4js.decrypt.bind(this, "123")) // decrypt
        .then(x => JSON.stringify(x.encrypted))
        .then(alert);

}

function decode(key, cipher) {
    aes4js.decrypt(key.value, cipher.value).then(x => output.value = x);
}

