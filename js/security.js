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


async function digestMessage(message) {
    const msgUint8 = new TextEncoder().encode(message);                           // encode as (utf-8) Uint8Array
    const hashBuffer = await crypto.subtle.digest('SHA-256', msgUint8);           // hash the message
    const hashArray = Array.from(new Uint8Array(hashBuffer));                     // convert buffer to byte array
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join(''); // convert bytes to hex string
    return hashHex;
}

function generateCypherKey(salt, pwd) {

}

function generateHashSaltedPassword(pwd) {

    if (window.localStorage.getItem('auth_salt') === undefined) {
        window.localStorage.setItem('auth_salt', '123');
    }

    salt = window.localStorage.getItem('auth_salt');

    pwd_salted = salt + pwd;

    return digestMessage(pwd_salted);
}

function encode(key, password) {

    aes4js.encrypt("123", "hello world") // encrypt with password 123
    // .then(aes4js.decrypt.bind(this, "123")) // decrypt
        .then(x => JSON.stringify(x.encrypted))
        .then(alert);

}

function decode(key, cipher) {
    aes4js.decrypt(key.value, cipher.value).then(x => output.value = x);
}


function register() {
    i_pwd = document.getElementById("i_pwd");
    i_salt = document.getElementById("i_salt_passwords")

    salt = "123";
    i_salt.value = salt;
    // A LA CONNEXION

    //key = generateCypherKey(salt,i_pwd.value);

    // --> Stocker clé dans  qqpart

    hashed = generateHashSaltedPassword(i_pwd.value);

    hashed.then((x) => {
        i_pwd.value = x;
    });



}
