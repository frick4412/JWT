/* ----------- NOT BEING USED -----------
// ***** PROMISES *****
var promLog = function(refid, planid, orderid, action) {
    return Promise.resolve(
        $.ajax({
            type: "post",
            url: "app/qry/logaction",
            dataType: "json",
            data: {refid:refid, planid:planid, orderid:orderid, username:objApp.username, action:action}
        })
    );
};
*/

/*
 * Use:
 * (include this javascript file)
 * var objJwt = new Jwt(apl, formdata, data);
 * var jwt = createJwt();
 */

/**
 * Global object to generate JWT
 *   Generates JWT for AJAX request
 * @param apl String : Code for the application
 * @param data Object : general data to be passed to API
 * @param formdata Object : form data to be passed to API
 * @constructor
 */
var Jwt = function(apl) {
	this.apl = apl;
};
Jwt.prototype.setAuthenticated = function(auth) {
    this.authenticated = auth;
};
Jwt.prototype.logAction = function(refid, planid, orderid, action) {
    promLog(refid, planid, orderid, action).then(
        function(resp) {
            console.log("Logged action.");
        },
        function(xhrObj) {
            alert("Failed to save action to log.");
        }
    );
};

//var objJwt = new Jwt();  // Do not auto-create.  Create from AJAX request code.
