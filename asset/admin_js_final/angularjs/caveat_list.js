var myapp = angular.module('my_app', ['datatables']);
myapp.controller('users', function ($scope, $http) {
    $scope.master = {};
    $scope.natureInformation = function () {
        $http({
            method: 'GET',
            url: 'caveat_ajax.php?action=caveat_list'
        }).then(function (success) {
            $scope.users_list = [];
            $scope.users_list = success.data;
        }, function (error) {
            console.log(error);
        });
    };
    $scope.addModal = function () {
        $scope.users_form = angular.copy($scope.master);
        $scope.form_name = 'Add IA Nature';
        $("#caveat_form_id #action_text").val('insert');
        $('#form_modal').modal('show');
    };

});