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
    $scope.users = [];
    $scope.collections = [];
    $scope.title = '';
    $scope.ativo = false;
    $http.get(url+'/admin/users').then(
        function (d) {
            // console.log(d.data);
            $scope.users = d.data;
        },
        function (e) {
            console.log(e);
        }
    );
    // $http.get(url+'/admin/orgaos').then(
    //     function (d) {
    //         // console.log(d.data);
    //         $scope.collections = d.data;
    //     },
    //     function (e) {
    //         console.log(e);
    //     }
    // );
    $scope.newTitle = function (ntitle, ativo) {
        $scope.title = ntitle;
        $scope.ativo = ativo;
    }

    $scope.remove = function(key) {
        $http.get(url+'/admin/users/'+key).then(
            function (d) {
                $scope.users = d.data;
            },function (e) {
                console.log(e);
            }
        );
    }
}

function addCtrl($scope, $http, $httpParamSerializerJQLike) {
    $scope.data = {};

    $scope.saveData = function (data, ativo) {

        var data = $httpParamSerializerJQLike(data);

        if(ativo) {
            $http.post(url+'/admin/users',data).then(
                function (d) {
                    $scope.data = d.data;
                },function (e) {
                    console.log(e);
                }
            );
        } else {
            $http.post(url+'/admin/orgaos',data).then(
                function (d) {
                    $scope.data = d.data;
                },function (e) {
                    console.log(e);
                }
            );
        }
    }

}