$( document ).ready(function(){

    $(".button-collapse").sideNav();
    $('select').material_select();

    $('#insMembreSelect').on('change', function() {
      switch (this.value) {
        case 'Arbitre' :
            $("#niveauArbitreDiv").prop("hidden", false);
            $("#numLicenceDiv").prop("hidden", false);
            $("#idEquipeDiv").prop("hidden", true);
          break;
        case 'Organisateur' :
          $("#niveauArbitreDiv").prop("hidden", true);
          $("#niveauArbitreInput").val('');
          $("#numLicenceDiv").prop("hidden", true);
          $("#numLicenceInput").val('');
          $("#idEquipeDiv").prop("hidden", true);
          break;
        case 'Coach' :
          $("#niveauArbitreDiv").prop("hidden", true);
          $("#niveauArbitreInput").val('');
          $("#numLicenceDiv").prop("hidden", false);
          $("#idEquipeDiv").prop("hidden", true);
          break;
        case 'Joueur' :
          $("#niveauArbitreDiv").prop("hidden", true);
          $("#niveauArbitreInput").val('');
          $("#numLicenceDiv").prop("hidden", false);
          $("#idEquipeDiv").prop("hidden", false);
          break;
        case 'Bénévole' :
          $("#niveauArbitreDiv").prop("hidden", true);
          $("#niveauArbitreInput").val('');
          $("#numLicenceDiv").prop("hidden", true);
          $("#numLicenceInput").val('');
          $("#idEquipeDiv").prop("hidden", true);
          break;
      }
    });

    $('#passwordVerifyInput').keyup( function() {
      if ($('#passwordVerifyInput').val() == $('#passwordInput').val() && $('#passwordInput').val() != '') {
        $('#errorMessagePassword').prop("hidden", true);
        $("#insMembreButton").prop("disabled", false);
      } else {
        $('#errorMessagePassword').prop("hidden", false);
        $("#insMembreButton").prop("disabled", true);
      }
    });

    $('#passwordInput').keyup( function() {
      if ($('#passwordVerifyInput').val() == $('#passwordInput').val() && $('#passwordInput').val() != '') {
        $('#errorMessagePassword').prop("hidden", true);
        $("#insMembreButton").prop("disabled", false);
      } else {
        $('#errorMessagePassword').prop("hidden", false);
        $("#insMembreButton").prop("disabled", true);
      }
    });

});
