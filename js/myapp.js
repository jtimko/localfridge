var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope, $http) {
  $http.get('test.php').success(function(data) {
    $scope.users = data;
  });
});
