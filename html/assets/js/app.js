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
    $scope.collections = [];
    $http.get(url+'/admin/token').then(
        function (d) {
            if (!localStorage.getItem('token')) {
                localStorage.setItem('token',d.data);
            }
        },
        function (e) {}
    );
    $http.get(url+'/admin/orgaos').then(
        function (d) {
            $scope.collections = d.data;
        },
        function (e) {
            console.log(e);
        }
    );
    $http.get(url+'/admin/reclamacao').then(
        function (d) {
            $scope.reclamcao = d.data;
        },
        function (e) {
            console.log(e);
        }
    );
    $http.get(url+'/admin/sugestao').then(
        function (d) {
            $scope.sugestao = d.data;
        },
        function (e) {
            console.log(e);
        }
    );
    $http.get(url+'/admin/elogio').then(
        function (d) {
            $scope.elogio = d.data;
        },
        function (e) {
            console.log(e);
        }
    );
    $http.get(url+'/admin/solicitacao').then(
        function (d) {
            $scope.solicitacao = d.data;
        },
        function (e) {
            console.log(e);
        }
    );
    $http.get(url+'/admin/denuncia').then(
        function (d) {
            $scope.denuncia = d.data;
        },
        function (e) {
            console.log(e);
        }
    );

}

function PanelCtrl($scope, $http, $httpParamSerializerJQLike) {
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
    $http.get(url+'/admin/orgaos').then(
        function (d) {
            $scope.collections = d.data;
        },
        function (e) {
            console.log(e);
        }
    );
    $scope.newTitle = function (ntitle, ativo) {
        $scope.title = ntitle;
        $scope.ativo = ativo;
    }

    $scope.remove = function(key) {
        $http.delete(url+'/admin/users/'+key).then(
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
    $scope.success = false;
    $scope.error = false;

    $scope.saveData = function (data, ativo) {

        var data = $httpParamSerializerJQLike(data);

        if(ativo) {
            $http.post(url+'/admin/users',data).then(
                function (d) {
                    $scope.success = true;
                },function (e) {
                    $scope.error = true;
                }
            );
        } else {
            $http.post(url+'/admin/orgaos',data).then(
                function (d) {
                    $scope.success = true;
                },function (e) {
                    $scope.error = true;
                }
            );
        }
    }

}