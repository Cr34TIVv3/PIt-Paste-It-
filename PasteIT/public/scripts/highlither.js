function highlight_code (lang_name){
    console.log(lang_name);
    switch(lang_name) {
        case "XML":
            generateXMLHighlighter();
            break;
        case "SQL":
            generateSQLHighlighter();
            break;
        case "C++":

            generateCPPHighlighter();
            break;
    }
}

function generateXMLHighlighter()
{
    code = document.getElementById("toHighlight");
    let data = code.innerHTML;
    
    data = data.replace(/"(.*?)"/g, '<span class="code-str"><b>&quot;$1&quot;</b></span>');
    data = data.replace(/&lt;(.*?)&gt;/g, '<span class="code-elem"><b>&lt;$1&gt;</b></span>');
    data = data.replace(/\/\* (.*?) \*\//g, '<span class="code-comment"><b>/* $1 */</b></span>');
    code.innerHTML = data;

}
function generateSQLHighlighter()
{
    code = document.getElementById("toHighlight");
    let data = code.innerText;
    // console.l


    // let words = data

    var operators = ['=', '(', ')', '*', ';', '!', ','];

    for(var i = 0; i < operators.length; i++) 
    {
        var re = new RegExp('\\' + operators[i], "gi");
        data = data.replace(re, '<span class="code-operator">' + operators[i] +'</span>');
    }
   
    

    var keywords = [' add ', ' alter ', ' and ', ' as ', ' column ', ' create ', ' database ', ' delete ',
        ' describe ', 'distinct', ' do ', ' drop ', ' explain ', ' from ', ' group by ',
        ' handler ', ' index  ', ' insert ', ' into ', ' inner join ', ' join ', ' left join ',
        ' limit ', ' on ', 'optimize ', ' order by ', ' outer join ', ' rename ', ' replace ',
        ' right join ', ' select ', ' set ', ' show ', ' table ', ' update ', ' use ', ' union ', ' where '];
    
    for(var i = 0; i < keywords.length; i++) 
    {
        var re = new RegExp(keywords[i], "gi");
        data = data.replace(re, '<span class="code-keyword">' + keywords[i].toUpperCase() +'</span>');
    }

    
    //comments
    //  data = data.replace(/\/\* (.*?) \*\//g, '<span class="code-comment">/* $1 */</span>');
    //  ///strings
    //  data = data.replace(/"(.*?)"/g, '<span class="code-str">&quot;$1&quot;</span>');

    code.innerHTML = data;
}
function generateCPPHighlighter()
{
    code = document.getElementById("toHighlight");
    let data = code.innerHTML;
    // var operators=  [' = ', '*', '+', '-', '&', '|', '!', '?', '^', '/',
    //     ':', '~', '%', '[', ']'];
    //     for(var i = 0; i < operators.length; i++) 
    //     {
    //         var re = new RegExp('\\' + operators[i], "gi");
    //         data = data.replace(re, '<span class="code-operator">' + operators[i] +'</span>');
    //     }


    var keywords = [' auto ', ' break ', ' case ', ' char ', ' const ', ' continue ', ' default ', ' do ', ' double ',
    ' else ', ' enum ', ' extern ', ' float ', ' for ', ' goto ', ' if ' , ' int ', ' long ', ' register ',
    ' return ', ' short ', ' signed ', ' sizeof ', ' static ', 'struct', 'switch', 'typedef', 'union',
    ' unsigned ', ' void ', ' volatile ', ' wchar_t ', ' while ', ' public ',' private ', ' class ', ' friend ', ' operator', ' cin '];
            for(var i = 0; i < keywords.length; i++) 
            {
                var re = new RegExp(keywords[i], "gi");
                data = data.replace(re, '<span class="code-keyword">' + keywords[i] +'</span>');
            }
         
            code.innerHTML = data;

}
























