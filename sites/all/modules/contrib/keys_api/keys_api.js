// $Id: keys_api.js,v 1.3.4.2 2008/10/16 17:10:42 greenskin Exp $

if (Drupal.jsEnabled) {
  $(document).ready(function() {

  });

  function setDomain() {
    $("#edit-domain").val(window.location.host);
  }

  function deleteItem(item) {
    $.each($("." + item + " td"), function(i, n) {
      if (i == 0) {
        domain = $(n).text();
      }
      if (i == 1) {
        service = $(n).text();
      }
    });
    
    $.post(Drupal.settings.basePath + "?q=admin/settings/keys/delete_key",{name:domain,service:service},function(data) {
      $("#keys_table").empty().append(data);
    });
  }
}