function uaredirect(f) {
02
    try {
03
        if (document.getElementById("bdmark") != null) {
04
            return
05
        }
06
        var b = false;
07
        if (arguments[1]) {
08
            var e = window.location.host;
09
            var a = window.location.href;
10
            if (isSubdomain(arguments[1], e) == 1) {
11
                f = f;
12
                b = true
13
            } else {
14
                if (isSubdomain(arguments[1], e) == 2) {
15
                    f = f;
16
                    b = true
17
                } else {
18
                    f = a;
19
                    b = false
20
                }
21
            }
22
        } else {
23
            b = true
24
        }
25
        if (b) {
26
            var c = window.location.hash;
27
            if (!c.match("fromapp")) {
28
                if ((navigator.userAgent.match(/(iPhone|iPod|Android|ios|iPad)/i))) {
29
                    location.replace(f)
30
                }
31
            }
32
        }
33
    } catch(d) {}
34
}
35
function isSubdomain(c, d) {
36
    this.getdomain = function(f) {
37
        var e = f.indexOf("://");
38
        if (e > 0) {
39
            var h = f.substr(e + 3)
40
        } else {
41
            var h = f
42
        }
43
        var g = /^www\./;
44
        if (g.test(h)) {
45
            h = h.substr(4)
46
        }
47
        return h
48
    };
49
    if (c == d) {
50
        return 1
51
    } else {
52
        var c = this.getdomain(c);
53
        var b = this.getdomain(d);
54
        if (c == b) {
55
            return 1
56
        } else {
57
            c = c.replace(".", "\\.");
58
            var a = new RegExp("\\." + c + "$");
59
            if (b.match(a)) {
60
                return 2
61
            } else {
62
                return 0
63
            }
64
        }
65
    }
66
};
