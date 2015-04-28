
//when the tab is clicked, load the appropriate information
$("#selectable").selectable({
      stop: function() {
        $( ".ui-selected", this ).each(function() {
          $("#searchtext").attr("placeholder", $(this).text());
          document.cookie = "selected=" + $(this).attr("id"); //allows selected to be saved across windows
          $.post("http://cs.wellesley.edu/~cmsconnect/cmsconnect/listview.php", {"category": $(this).attr("id")}, function(data){console.log(data);$("#resultList").empty().html(data);});
        });
      }
    });
