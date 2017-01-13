// Objet AutoCompletion
function AutoCompletion (){
    this.elementList = null;
}
 
AutoCompletion.prototype = {
    constructor: AutoCompletion,
    setElementList: function(elmList){
        var tempList = JSON.parse(elmList);
        if( tempList.elements ){
            this.elementList = tempList.elements.map(function(elm){
                return elm.element;
            });
        }
    },
 
    completeWord: function(txt){
        if(txt){
        var i = 0, l = this.elementList.length;
            for(; i < l; i++){
                if(this.elementList[i].indexOf(txt) == 0){
                    return this.elementList[i];
                }
            }
        }
    },
 
    highlightInputText: function(tgt, word){
        if( word ){
            var start = tgt.value.length;
            tgt.value = word;
            tgt.selectionStart = start;  
        }
    }
};
 
// Init AutoCompletion
var aAutoComp = [
        { id: 'article_tags', url: 'http://localhost/blog/web/app_dev.php/tags/tag/json_all' },
        { id: 'article_games', url: 'http://localhost/blog/web/app_dev.php/game/game/json_all' },
        { id: 'article_licences', url: 'http://localhost/blog/web/app_dev.php/game/licence/json_all' },
        { id: 'article_developers', url: 'http://localhost/blog/web/app_dev.php/game/developer/json_all' },
        { id: 'article_publishers', url: 'http://localhost/blog/web/app_dev.php/game/publisher/json_all' }
    ],
    i = 0, l = aAutoComp.length;
 
aAutoComp.forEach( function(rAutoComp){
    var ipt = document.getElementById(rAutoComp.id),
        auto = new AutoCompletion();
 
    ipt.addEventListener('keyup', function(e){
        if(this === document.activeElement && auto.elementList ){
            var lidx = this.value.lastIndexOf(', '),
                text = lidx == -1 ?
                    this.value :
                    this.value.substring(lidx + 2),
                word = auto.completeWord(text);
            auto.highlightInputText(this, word);
        }
    }, false);
 
    ajaxGet(rAutoComp.url, function(result){
        auto.setElementList(result);
    });
} );