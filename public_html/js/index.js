$( document ).ready(function(){

    $(".button-collapse").sideNav();
    $('select').material_select();

    $('#insMembreSelect').on('change', function() {
      switch (this.value) {
        case 'Arbitre' :
            $("#niveauArbitreDiv").prop("hidden", false);
            $("#niveauArbitreInput").prop("disabled", false);
            $("#numLicenceDiv").prop("hidden", false);
            $("#numLicenceInput").prop("disabled", false);
            $("#idEquipeDiv").prop("hidden", true);
            $("#selectIdEquipe").prop("disabled", true);
          break;
        case 'Organisateur' :
        case 'Benevole' :
          $("#niveauArbitreDiv").prop("hidden", true);
          $("#niveauArbitreInput").prop("disabled", true);
          $("#niveauArbitreInput").val('');
          $("#numLicenceDiv").prop("hidden", true);
          $("#numLicenceInput").prop("disabled", true);
          $("#numLicenceInput").val('');
          $("#idEquipeDiv").prop("hidden", true);
          $("#selectIdEquipe").prop("disabled", true);
          break;
        case 'Coach' :
          $("#niveauArbitreDiv").prop("hidden", true);
          $("#niveauArbitreInput").prop("disabled", true);
          $("#niveauArbitreInput").val('');
          $("#numLicenceDiv").prop("hidden", false);
          $("#numLicenceInput").prop("disabled", false);
          $("#idEquipeDiv").prop("hidden", true);
          $("#selectIdEquipe").prop("disabled", true);
          break;
        case 'Joueur' :
          $("#niveauArbitreDiv").prop("hidden", true);
          $("#niveauArbitreInput").prop("disabled", true);
          $("#niveauArbitreInput").val('');
          $("#numLicenceDiv").prop("hidden", false);
          $("#numLicenceInput").prop("disabled", false);
          $("#idEquipeDiv").prop("hidden", false);
          $("#selectIdEquipe").prop("disabled", false);
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
