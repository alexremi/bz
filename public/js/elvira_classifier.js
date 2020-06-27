(function($){
    $.fn.extend({
        jQuizler: function(questions) {
            // @todo избавиться от возможности двойного клика по кнопкам "cследующий", "предыдущий", "результат"
            // @todo добавить возможность выбора нескольких вариантов ответа
            // @todo добавить возможность внедрения названия теста на страницу результатов
            // @todo избавиться от зависимости Bootsrap CSS
            // @todo поработать над стилем элементов кнопок и прогресса
            // @todo добавить кнопки "поделиться" или "like" для разных соц сетей ("ВКонтакте", "Однолкассники", ...)
            // @todo разобраться с проблемой клика по элементу кнопки на странице результатов
            // @todo переписать код, сделать его более изящным и чистым
            // @todo сделать так, чтобы плагин можно было применять для 2х и более тестов на страницу
            // @todo создать online инструмент для формирования и редактирования вопросов

            if (questions == null)
                throw 'No questions was provided.';

            var reviewQuiz = false;

            var percentage = 0;
            var percentPiece = 100 / questions.length;

            var rightAnswers = 0;

            $(this).html("<div class=\"intro\">" + $(this).html() + "</div>");

            $(this).click(function(){
                $(this).off('click');

                $(".intro").hide();
                $(this).css("text-align", "left");
                $('.progress').css("display", "block");

                var question = $("#question-1");

                question.css({opacity : '0', height : '0px'});

                question.animate({
                    opacity : '1',
                    height : '100%'
                }, 500, function(e){});

                question.css('display', 'block');

                percentage += percentPiece;
                $(".progress div").css("width", percentage + "%");
            });

            (function($){
                $.shuffle = function(arr) {
                    for(
                            var j, x, i = arr.length; i;
                            j = parseInt(Math.random() * i),
                                    x = arr[--i], arr[i] = arr[j], arr[j] = x
                            );
                    return arr;
                }
            })(jQuery);

            String.prototype.replaceAll = function (find, replace) {
                var str = this;
                return str.replace(new RegExp(find, 'g'), replace);
            };

            return this.each(function(){
                var html = "";

                html += "<div class=\"results slide-container question\" style=\"display:none\"></div>";



                $.each(questions, function(index, question){
                    html += "<div id=\"question-" + (index + 1) + "\" class=\"slide-container question\">";
                    //html += "<div class=\"question-number\">Вопрос " + (index + 1) + ' из ' + questions.length + "</div><div style=\"margin:0px; clear:both\"></div>";

                    html += question.question;

                    // var correctAnswers = [];
                    // for (var i = 0; i < question.correct.length; i++)
                    //     correctAnswers.push(question.answers[question.correct[i] - 1]);

                    // question.answers = $.shuffle(question.answers);

                    // var correctAnswersNewIndexes = [];
                    // for (var i = 0; i < question.correct.length; i++)
                    //     correctAnswersNewIndexes.push(question.answers.indexOf(correctAnswers[i]));

                    // question.correct = correctAnswersNewIndexes;

                    /*for (var i = 0; i < question.correct.length; i++)
                     console.log(question.answers[correctAnswersNewIndexes[i]]);*/

                    html += "<ul class=\"answers\">";

                    for (var i = 0; i < question.answers.length; i++)
                        html += "<li class=\"btn\">" + question.answers[i] + "</li>";

                    html += "</ul>";
                    html += "<div class=\"nav-container\">";

                    html += "<div class=\"notice alert alert-info\">Выберите пункт, подходящий для описания вашего артефакта</div>";

                    if (index != 0) {
                        html += "<button class=\"prev btn btn-info\"><i class='icon-arrow-left icon-white'></i> Предыдущий</button>";
                    }

                    if (index != questions.length-1) {
                        html += "<button class=\"next btn btn-success\">Следующий <i class='icon-arrow-right icon-white'></i></button>";
                        html += "<div style=\"clear:both\"></div>";

                    } else {
                        html += "<button class=\"final btn btn-success\">Результат классификации <i class='icon-ok icon-white'></i></button>";
                        html += "<div style=\"clear:both\"></div>";
                    }

                    html += "</div></div>";

                    html += "</div>";
                });



                html += "<div class=\"progress progress-info progress-striped\">";
                html += "<div id=\"percent\" class=\"bar\" style=\"width: 0%;\"></div>";
                html += "</div>";

                ///html += "<div style=\"margin:0px; clear:both\"></div>";
                $(this).append(html);

                $("div[id*='question-'] li").click(function(){
                    if (!reviewQuiz) {
                        /*$(this).siblings().removeClass("selected");
                        $(this).toggleClass("selected");*/

                        $(this).siblings().removeClass("btn-info");
                        $(this).toggleClass("btn-info");
                    }
                });



                $(".final").click(function(e){
                    var div = $(e.target).closest("div[id*='question-']");
                    var userAnswer = div.find("li.btn-info");

                    // if (userAnswer.index() == -1 && !reviewQuiz) {
                    if (false) {
                        var notice = div.find(".notice");
                        notice.css('opacity', '0');

                        notice.animate({
                            opacity: 1
                        }, 500, function(){});

                        div.find(".notice").css('display', 'block');
                    } else if (!reviewQuiz) {
                        div.find(".notice").css('display', 'none');

                        percentage += percentPiece;
                        if (percentage > 100) percentage = 100;
                        $("#percent").css("width", percentage + "%");

                        var resultHTML = "<h3 style=\"text-align: center\">РЕЗУЛЬТАТЫ</h3>";

                        var buttonsHTML = '';
                        answersHtml = '';
                        $.each(questions, function(index, question){
                            //console.log("Результат классификаци: " + question.correct);

                            var element = $("#question-" + (index+1) + " ul li.btn-info");
                            //console.log("от этого избавиться надо: " + element.index());
                            console.log(element.index())
                            if (element.index() === -1)
                                return
                            switch (index) {
                                case 0:
                                    if (element.index() === 0)
                                        answersHtml += 'керамика '
                                    else
                                        answersHtml +='фарфор '
                                    break;

                                case 1:
                                    if (element.index() === 0)
                                        answersHtml += 'фарфор ';
                                    else
                                        answersHtml += 'керамика ';
                                    break;

                                case 2:
                                    if (element.index() === 0)
                                        answersHtml += 'керамика ';
                                    else
                                        answersHtml += 'фарфор ';
                                    break;

                                case 3:
                                    if (element.index() === 0)
                                        answersHtml += 'фарфор ';
                                    else
                                        answersHtml += 'керамика ';
                                    break;

                                case 4:
                                    if (element.index() === 0)
                                        answersHtml += 'твёрдый ';
                                    else
                                        answersHtml += 'мягкий ';
                                    break;

                                case 5:
                                    if (element.index() === 0)
                                        answersHtml += 'твердый бисквитный фарфор ';
                                    break;

                                case 6:
                                    if (element.index() === 0)
                                        answersHtml += 'твердый фарфор с твердой глазурью ';
                                    break;

                                case 7:
                                    if (element.index() === 0)
                                        answersHtml += 'тонкая керамика ';
                                    break;

                                case 8:
                                    if (element.index() === 0)
                                        answersHtml += 'грубая керамика '
                                    break;

                                case 9:
                                    if (element.index() === 0)
                                        answersHtml += 'керамика, покрытая глазурью '
                                    else 
                                        answersHtml += 'нет следов глазури '
                                    break;

                                case 10:
                                    if (element.index() === 0)
                                        answersHtml += 'майолика '
                                    else 
                                        answersHtml += 'фаянс '
                                    break;

                                case 11:
                                    if (element.index() === 0)
                                        answersHtml += 'cтроительная керамика (грубозернистая) '
                                    else if (element.index() === 1)
                                        answersHtml += 'санитарно-технические изделия (фаянс, полуфарфор) '
                                    else if (element.index() === 2)
                                        answersHtml += 'бытовая и художественно-декоративная керамика (фаянс, полуфарфор, майолика) '
                                    else if (element.index() === 3)
                                        answersHtml += 'огнеупорная керамика (алюмосиликатная, кремнеземистая, магнезиальная, хромистая) '
                                    
                                    break;

                                case 12:
                                    if (element.index() === 0)
                                        answersHtml += 'техническая керамика '
                                    else if (element.index() === 1)
                                        answersHtml += 'кислотоупорная («каменная», кислотоупорный фарфор) '
                                    else if (element.index() === 2)
                                        answersHtml += 'бытовая и художественно-декоративная керамика (твердый и мягкий хозяйственный фарфор) '
                                    else if (element.index() === 3)
                                        answersHtml += 'санитарно-строительные изделия (низкотемператур­ный фарфор) '
                                    
                                    break;

                                case 13:
                                    if (element.index() === 0)
                                        answersHtml += 'древнейшая керамика Японских островов (восточно азиатский район) '
                                    else if (element.index() === 1)
                                        answersHtml += 'древняя керамика южного Китая (восточно азиатский район) '
                                    else if (element.index() === 2)
                                        answersHtml += 'западное Приморье (восточноазиатский район) '
                                    else if (element.index() === 3)
                                        answersHtml += 'северный Китай (восточноазиатский район) '
                                    else if (element.index() === 4)
                                        answersHtml += 'западная азия '
                                    else if (element.index() === 5)
                                        answersHtml += 'североафриканский район  '
                                    
                                    break;
                            }
                            // answersHtml += 'Вопрос:<br>';
                            // answersHtml += '<span>'+question["question"].replaceAll('<h3>', '').replaceAll('</h3>', '')+'</span><br>';
                            // answersHtml += 'Ответ:<br>';
                            // answersHtml += '<span>'+element.text()+'</span><br><br>';

                            // if (element.index() == question.correct) {
                            //     element.removeClass("btn-info");
                            //     element.addClass("btn-success");

                            //     buttonsHTML += "<button class=\"btn btn-success\"><i class='icon-ok-sign icon-white'></i> Вопрос " + (index+1) + "</button>";
                            //     rightAnswers++;
                            // } else {
                            //     element.removeClass("btn-info");
                            //     element.addClass("btn-danger");

                            //     buttonsHTML += "<button class=\"btn btn-danger\"><i class='icon-remove-sign icon-white'></i> Вопрос " + (index+1) + "</button>";

                            //     for (var i=0; i<question.correct.length; i++) {
                            //         element.parent().find('li').eq(question.correct[i]).addClass("btn-success");
                            //     }
                            // }
                        });

                        
                        resultHTML += buttonsHTML;
                        resultHTML += answersHtml;
                        resultHTML += "<p style=\"margin-top:25px; text-align: center\"><button class=\"btn btn-large tostart\">Просмотреть вопросы</button></p>";

                        div.animate({
                            opacity : '0'
                        }, 500, function(e){
                            div.css('display', 'none');
                            div.find(".notice").css('display', 'none');

                            $(".results").append(resultHTML);
                            $(".results").css("opacity", "0");
                            $(".results").css("display", "block");

                            $(".results").animate({
                                opacity : '1'
                            }, 500, function(e){
                            });
                        });

                        $(".progress").animate({
                            opacity : '0'
                        }, 100, function(e){});

                        reviewQuiz = true;
                    } else {
                        $(".results").animate({
                            opacity: "1",
                            display: "block"
                        }, 100, function(e){});

                        div.animate({
                            opacity : '0'
                        }, 500, function(e){
                            div.css('display', 'none');
                            div.find(".notice").css('display', 'none');

                            $(".results").append(resultHTML);
                            $(".results").css("opacity", "0");
                            $(".results").css("display", "block");

                            $(".results").animate({
                                opacity : '1'
                            }, 500, function(e){
                            });
                        });

                        $(".progress").animate({
                            opacity : '0'
                        }, 100, function(e){});
                    }

                    return false;
                });

                $(".next").click(function(e){
                    var div = $(e.target).closest("div[id*='question-']");
                    var userAnswer = div.find("li.btn-info");

                    // if (userAnswer.index() == -1 && !reviewQuiz) {
                    //     var notice = div.find(".notice");
                    //     notice.css('opacity', '0');

                    //     notice.animate({
                    //         opacity: 1
                    //     }, 500, function(){});

                    //     div.find(".notice").css('display', 'block');
                    // } else {

                        var nextId = parseInt(div.attr('id').replace('question-', '')) + 1;
                        //console.log(nextId);

                        var newQuestion = $("#question-" + nextId);

                        div.animate({
                            opacity : '0'
                        }, 500, function(e){
                            div.css('display', 'none');
                            div.find(".notice").css('display', 'none');

                            newQuestion.css({opacity : '0', height : '0px'});

                            newQuestion.animate({
                                opacity : '1',
                                height : '100%'
                            }, 500, function(e){});

                            newQuestion.css('display', 'block');
                        });

                        percentage += percentPiece;
                        $(".progress div").css("width", percentage + "%");
                    // }

                    return false;
                });

                $(".prev").click(function(e){
                    var div = $(e.target).closest("div[id*='question-']");

                    var prevId = parseInt(div.attr('id').replace('question-', '')) - 1;

                    var newQuestion = $("#question-" + prevId);

                    div.animate({
                        opacity : '0'
                    }, 500, function(e){
                        div.css('display', 'none');
                        //div.find(".notice").css('display', 'none');

                        newQuestion.css({opacity : '0', height : '0px'});

                        newQuestion.animate({
                            opacity : '1',
                            height : '100%'
                        }, 500, function(e){});

                        newQuestion.css('display', 'block');
                    });

                    percentage -= percentPiece;
                    $(".progress div").css("width", percentage + "%");

                    return false;
                });

                $(".results").click(function(e){
                    $(".results").animate({opacity: 0}, 500, function(e){
                        $(".results").css("display", "none");

                        var question = $("#question-1");

                        question.css({opacity : '0', height : '0px'});

                        question.animate({
                            opacity : '1',
                            height : '100%'
                        }, 500, function(e){});

                        question.css('display', 'block');

                        $(".progress div").css("width", "0");
                        $(".progress div").css("display", "block");
                        $(".progress").animate({
                            opacity : '1'
                        }, 300, function(e){
                            percentage = 0;
                            percentage += percentPiece;
                            $(".progress div").css("width", percentage + "%");
                        });
                     });
                });
            });
        }
    });


})(jQuery);