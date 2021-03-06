<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- heroku -->
    <title>Shoelace - Visual Bootstrap 3 Grid Builder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="The only visual Bootstrap 3 grid builder featuring full responsive media query views and fully functional preview.">
    <script src="//code.jquery.com/jquery-latest.min.js"></script>
    <script src="//use.typekit.net/xlr6gwy.js"></script>
    <script>try{Typekit.load();}catch(e){}</script><!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.2.0/respond.js?b45bc0"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js?b45bc0"></script><![endif]-->
	
	<link rel="stylesheet" type="text/css" href="../fontawesome-5.8.1/css/all.min.css" />

    <link rel="stylesheet" href="css/bigsky.aui.css">
    <link rel="stylesheet" href="css/styles.css">
    <link href="favicon.png" rel="shortcut icon" type="image/png">
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-45551267-1', 'shoelace.io');
      ga('send', 'pageview');

    </script>
  </head>
  <body>
    <header>
      <div class="logo"></div>
      <div class="menu">
        <ul class="modify">
          <li><a class="btn btn-shoelace btn-save"><i class="icon-cloud-upload"> </i>Save</a></li>
          <li><a class="btn btn-shoelace btn-update hidden"><i class="icon-cloud-upload"> </i>Update</a></li>
          <li><a class="btn btn-shoelace btn-preview hidden"><i class="icon-eye-open"> </i>Preview</a></li>
          <li><a class="btn btn-shoelace btn-edit hidden"><i class="icon-pencil"> </i>Edit</a></li>
          <li><a class="btn btn-shoelace btn-edit" href="mailto:erik+shoelace@helloerik.com?Subject=Shoelace-Feedback"><i class="icon-envelope"> </i>Send Feedback!</a></li>
        </ul>
      </div>
    </header>
    <div class="application-frame easing">
      <div class="panels-wrapper">
        <div class="navigator easing">
          <div class="preview xs easing">
            <div class="title-bar">
              <div class="size-icon"><i class="icon-mobile-phone"> </i></div>
              <div class="title">Phone</div>
            </div>
            <div class="preview-container">
              <div class="preview-rows"></div>
            </div>
          </div>
          <div class="preview sm easing">
            <div class="title-bar">
              <div class="size-icon"><i class="icon-tablet"> </i></div>
              <div class="title">Tablet</div>
            </div>
            <div class="preview-container">
              <div class="preview-rows"></div>
            </div>
          </div>
          <div class="preview md easing">
            <div class="title-bar">
              <div class="size-icon"><i class="icon-laptop"> </i></div>
              <div class="title">Desktop</div>
            </div>
            <div class="preview-container">
              <div class="preview-rows"></div>
            </div>
          </div>
          <div class="preview lg easing">
            <div class="title-bar">
              <div class="size-icon"><i class="icon-desktop">  </i></div>
              <div class="title">Large Desktop</div>
            </div>
            <div class="preview-container">
              <div class="preview-rows"></div>
            </div>
          </div>
        </div>
        <div class="workspace easing"></div>
        <div class="html easing">
          <div class="collapse-panel right"> <span class="open"><i class="icon-caret-right"> </i></span><span class="closed"><i class="icon-caret-left"> </i></span></div>
          <div class="html-wrapper">
            <div class="options easing">
              <ul>
                <li class="output-html easing active">HTML</li>
                <li class="output-jade easing">Jade</li>
                <li class="output-edn easing">EDN</li>
              </ul>
              <div class="container-check">
                <label>
                  <input type="checkbox" class="use-less-mixin">Use LESS Mixin
                </label>
                <label>
                  <input type="checkbox" class="include-container">Include Container
                </label>
              </div>
              <div class="clear"></div>
            </div>
            <div class="output_container">
              <div class="copy-code">Copy</div>
              <pre class="output prettyprint lang-html markup"></pre>
              <pre class="output prettyprint lang-text mixins"></pre>
            </div>
            <textarea class="copy-output"></textarea>
          </div>
        </div>
      </div>
    </div>
    <div class="preview preview-pane hidden">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">Hover Guide
            <ul class="hover-guide">
              <li class="container-guide">Gray - Container</li>
              <li class="row-guide">Red - Row</li>
              <li class="col-guide">Blue - Col</li>
              <li></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="container output-preview"></div>
    </div>
    <footer>
      <ul>
        <li><a href="http://www.getbootstrap.com">Get Bootstrap</a></li>
      </ul>
    </footer>
    <div class="blackout-overlay">
      <div class="notification">Lacing it up!</div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.js"></script>
    <script type="text/javascript" src="http://jsbeautifier.org/js/lib/beautify-html.js"></script>
    <script type="text/javascript" src="js/cljs.js"></script>
  </body>
</html>
