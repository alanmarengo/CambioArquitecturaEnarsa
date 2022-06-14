$(document).ready(function() {
    $('#main-search').focusin(function() {
        $(this).attr('placeholder', '');
    });

    $('#main-search').focusout(function() {
        $(this).attr('placeholder', 'Buscar en todo el sitio');
    });

    $('#main-search').on('keypress', function(e) {
        if (e.which == 13) {
            var isMediateca = this.getAttribute("data-mediateca");
            //let url = "./mediateca.php?s=" + $(this).val();
            //window.location.replace(url);
            var pattern = $("#main-search").val();
            var url = "./mediateca.php?s=" + pattern;
            var flink = document.createElement("a");
            flink.href = url;
            if (isMediateca == "") {
                flink.target = "_blank";
            } else {
                flink.target = "_self";
            }
            document.body.appendChild(flink);
            flink.click();
            $(flink).remove();
        }
    });

    $('#main-search-btn').on('click', function(e) {
        var isMediateca = this.getAttribute("data-mediateca");
        //let url = "./mediateca.php?s=" + $(this).val();
        //window.location.replace(url);
        var pattern = $("#main-search").val();
        var url = "./mediateca.php?s=" + pattern;
        var flink = document.createElement("a");
        flink.href = url;
        if (isMediateca == "") {
            flink.target = "_blank";
        } else {
            flink.target = "_self";
        }
        document.body.appendChild(flink);
        flink.click();
        $(flink).remove();
    });



});


$.urlParam = function(name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)')
        .exec(window.location.search);

    return (results !== null) ? results[1] || 0 : false;
};