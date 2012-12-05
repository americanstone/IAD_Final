$(document).ready(function(){

    var courseID =document.getElementById("content").getAttribute('course-id');

    $("#submitButton").click(function (event){
        var groups = [];
        $('.column').each(function(){
            var id = ($(this).attr('id'));          
            var group = {};
            group['id'] = id;
            group['member'] = [];
            $('#'+id+' .card').each(function(){
                group['member'].push({email:$(this).attr('id')});
            });
           groups.push(group);
        });
        var groupData = JSON.stringify(groups);
        $.ajax({
            url:"server/addGroups.php",
            data: {'course': courseID, 'groups': groupData},
            dataType: 'text',
            success:function(data){
                alert('groups are created');
            }
            
        });
    })
    $("#disbandButton").click(function(event){
        $.ajax({
            url:"server/addGroups.php",
            data: {'course': courseID, 'groups': '[]'},
            dataType: 'text',
            success:function(data){
                window.location.reload();
            }
            
        });
    })

    $("#refresh").click(function(event){
        window.location.reload();
    })

    $(".addimg").on('click',function(event){
        event.preventDefault();

        var numOfCards = 0;

        var cards = document.getElementById("cards").childNodes;
        for(n=0; n<cards.length;n++){
            //document.wr
            if(cards[n].nodeType == 1){
                    //document.write('here');
                    numOfCards++;
            }
        }

        //number of groups currently have
        var i = $('.column').length + 1;
        $("#columns").append('<div id="group'+i+'" class="column"><header class="head">group '+i+'</header></div>');
        draggableRebind();			

    });//end of addimg binding
    
    //send Ajax request to get students who are enrolled the course
    //but not be in any group. and put such students into cards-table
    $.ajax({
            url: "server/getCards.php",
            data: {course: courseID},
            dataType: "text",
            success: function(data){

                    var thtml = "<div id='cards'>";
                    thtml += data;
                    thtml += "</div>";
                    $("#cards-table").html(thtml);
                    draggableRebind();
            }
    });
        
    //send Ajax request to get students cards
    $.ajax({
            url: "server/loadgroups.php",
            data: {course: courseID},
            dataType: "xml",
            success: function(data){
                var k=0;
                var thtml = "";
                $(data).find("group").each(function(){
                    var groupName = $(this).attr("groupname");
                    thtml += '<div id="'+groupName+'" class="column"><header class="head">'+groupName+'</header>';
                    $(this).find("member").each(function(){
                        var email = $(this).find("email").text();
                        thtml += '<div class="card card-thumb" draggable="true" id="'+email+'" ><div class="id-image">'
                            +'<img class="" width="50" height="50" src="'+$(this).find("image").text()+'"></div>'
                            +'<a href=""><span class="id-infor">'+$(this).find("name").text() +'<br/>'
                            + email +'</span></a></div>';
                    });
                    thtml +='</div>'
                    
                });
                $('#columns').html(thtml);
                /*rebind DnD to groups and cards*/
                    draggableRebind();
            }
    });

});

    function disbandGroupAjax(){

            var queryString ='';
            //queryString =// c
            queryString = checkGroups(queryString);	
            //document.write(queryString);
            if(queryString){
                    URL = "server/disbandGroup.php"
                    disbandGroup_xhr.open("POST", URL, true);
                    disbandGroup_xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                    //document.write(queryString);
                    disbandGroup_xhr.send(queryString);
            }

    }
    
    


    
function trim(s) { 
    s = s.replace(/(^\s*)|(\s*$)/gi,"");
    s = s.replace(/[ ]{2,}/gi," "); 
    s = s.replace(/\n /,"\n"); return s;
}

function draggableRebind(){


                    var dragSrcEl = null;
                    function handleDragStart(e) {
                            //Target (this) element is the source node.
                            //this.style.opacity = '0.4';
                            dragSrcEl = this;
                            var data = $(this).clone().wrap('<div>').parent().html();//data is the <div class="card" itself
                            e.dataTransfer.effectAllowed = 'move';
                            e.dataTransfer.setData('text/html', data);
                    }

                    function handleDragEnd(e) {// this /e.target is the target node. "columes" in this case
                            [].forEach.call(cols, function (col) {
                            col.classList.remove('over');
                                    });
                    }

                            // dragOver will fire many times during the graging. this is "card" in this case
                    function handleDragOver(e) {
                            if (e.preventDefault) {
                                            e.preventDefault(); // Necessary. Allows us to drop.
                            }

                                      e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.

                                    return false;

                    }


                    //gradEnter will fire many times during enter the destination 
                    function handleDragEnter(e) {

                            this.classList.add('over'); // this / e.target is the current hover target. this case is the "card"

                    }


                    function handleDragLeave(e) {

                            this.classList.remove('over');   // this / e.target is previous target element. "columes" in this case
                    }	

                    function handleDrop(e) {
                            // this/e.target is current target element.
                            if (e.stopPropagation) {
                                    e.stopPropagation(); // Stops some browsers from redirecting.
                            }

                            //alert("[Drop event] e.data is " + $(this).clone().wrap('<div>').parent().html()+" [will append] " + e.dataTransfer.getData('text/html'));

                            //get source element id
                            var id = dragSrcEl.attributes.getNamedItem('id').textContent;

                            //get elemets already located
                            var ids = new Array();
                            // Don't do anything if dropping the same column we're dragging.
                            $(this).children().each(function(){
                                    //alert($(this).attr('id'));
                                    ids.push($(this).attr('id'))
                            });

                            if (ids.indexOf(id) == -1) {
                                    $(this).append(e.dataTransfer.getData('text/html'));
//                                    $(this).find($('.card')).addClass('card-thumb');
//                                    $(this).find('img').addClass('img-thumb');
                                    var cards = document.querySelectorAll('.card');
                                            [].forEach.call(cards, function(card){
                                            card.addEventListener('dragstart', handleDragStart, false);
                                            card.addEventListener('dragenter', handleDragEnter, false);
                                            card.addEventListener('dragover', handleDragOver, false);
                                            card.addEventListener('dragleave', handleDragLeave, false);
                                            card.addEventListener('dragend', handleDragEnd, false);
                                    });

                                    $(dragSrcEl).wrap('<div>').parent().empty();

                            }
                            return false;
                    }

                    var cols = document.querySelectorAll('#columns .column');
                    [].forEach.call(cols, function(col) {
                    col.addEventListener('dragenter', handleDragEnter, false);
                    col.addEventListener('dragover', handleDragOver, false);
                    col.addEventListener('dragleave', handleDragLeave, false);
                    col.addEventListener('drop', handleDrop, false);
                    col.addEventListener('dragend', handleDragEnd, false);
                    });

                    var cards = document.querySelectorAll('.card');
                    [].forEach.call(cards, function(card){
                    card.addEventListener('dragstart', handleDragStart, false);
                    card.addEventListener('dragenter', handleDragEnter, false);
                    card.addEventListener('dragover', handleDragOver, false);
                    card.addEventListener('dragleave', handleDragLeave, false);
                    card.addEventListener('dragend', handleDragEnd, false);
                    });

            }



