/**
 * Created by jacson on 23/01/2017.
 */
var url = 'http://localhost:4040';
var app = angular.module('app',[]);

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
})
.config(function($httpProvider){
        $httpProvider.defaults.headers.post["Content-Type"]   = "application/x-www-form-urlencoded";
        $httpProvider.defaults.headers.put["Content-Type"]   = "application/x-www-form-urlencoded";
        $httpProvider.defaults.headers.common["Content-Type"] = "application/x-www-form-urlencoded";
        $httpProvider.defaults.headers.common["Authorization"] = 'Bearer '+ localStorage.getItem('token');
    });

app.controller('AppCtrl',appCtrl)
.controller('PanelCtrl',PanelCtrl)
.controller('AddCtrl',addCtrl);

function appCtrl($scope, $http) {
    
    $http.get(url+'/admin/token').then(
        function (d) {
            if (!localStorage.getItem('token')) {
                localStorage.setItem('token',d.data);
            }
        },
        function (e) {}
    )
    
}

function PanelCtrl($scope, $http) {

}

function addCtrl($scope, $http) {

}