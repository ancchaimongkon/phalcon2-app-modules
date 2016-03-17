jQuery(document).ready(function($) {
    $('a[data-rel^=lightcase]').lightcase({
        showTitle: false
    });
});

function path(){
    var args = arguments,result = [] ;
    for(var i = 0; i < args.length; i++){
        result.push(args[i].replace("@", "/vendor/syntax-highlighter-3.0.83/scripts/"));
    }
    return result;
};
SyntaxHighlighter.autoloader.apply(null, path(
    "c# c-sharp csharp      @shBrushCSharp.js",
    "css                    @shBrushCss.js",
    "java                   @shBrushJava.js",
    "jfx javafx             @shBrushJavaFX.js",
    "js jscript javascript  @shBrushJScript.js",
    "php                    @shBrushPhp.js",
    "sql                    @shBrushSql.js",
    "vb vbnet               @shBrushVb.js",
    "xml xhtml xslt html    @shBrushXml.js"
));

SyntaxHighlighter.config.stripBrs = false;
SyntaxHighlighter.defaults['auto-links'] = false;
SyntaxHighlighter.config.strings.expandSource = 'Show Syntax : Click !!';
SyntaxHighlighter.all();