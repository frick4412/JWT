function Jwt(apl, url, data, formdata) {
    var self = this;
    this.apl = apl;
    this.usr = localStorage.getItem(apl + ".usr");
    this.url = url;
    this.data = data;
    this.formdata = formdata;
    
    this.part1 = function() {
        var str = '{"alg":"HS256","typ":"JWT"}';  // json code
        str = window.btoa(str);  // base64 encode
        return str;
    };
    this.part2 = function() {
        var dt = new Date();
        var nbf = dt.getTime() - 1000 * 60 * 5;
        var exp = dt.getTime() + 1000 * 60 * 5;
        var p2 = {};
        p2.iss = "fhf";
        p2.apl = apl;
        p2.usr = "scrombie";  // localStorage.getItem(apl + ".usr");
        p2.nbf = nbf;
        p2.exp = exp;
        p2.url = url;
        p2.data = data;
        p2.formdata = formdata;
        p2.test = "test test test";
        var str = JSON.stringify(p2);  // object to json string
        str = window.btoa(str);  // base64 encode
        return str;
    };
    this.part3 = function() {
        var str = self.part1() + "." + self.part2();
        console.log("part1: " + self.part1());
        console.log("part2: " + self.part2());
        var tkn = "12345";  // localStorage.getItem(apl + ".tkn");

        str = CryptoJS.HmacSHA256(str, tkn);
        console.log("p3 in hex: " + str);
        str = CryptoJS.enc.Base64.stringify(str);
        //str = btoa(str);
    
        console.log("part3: " + str);
        //str = str.substring(0, str.length-1);  // remove = at end
        return str;
    };
    this.jwt = function() {
        // eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJmaGYifQ.1MLiFy3-Rce8K_3Wn8tyFrUqqj7rqtuOdtXbLggHAYU
        var str = self.part1() + "." + self.part2() + "." + self.part3();
        return str;
    };
}