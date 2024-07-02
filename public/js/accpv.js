// Librairie javascript qui permet l'auto complétion du nom de ville via le code postal (avec 3, 4 ou les 5 chiffres)
// Créer le 24/05/2017 par MICHENEAU Simon (Fukotaku)


// Variables globaux
/* var url_api = "https://data.opendatasoft.com/api/records/1.0/search/?dataset=code-postal-code-insee-2015%40public";
var params = "";
var paramsPlus = "&rows=100";
var codes_postaux = {};


// Fonction qui génère le paramètre utilisé pour la recherche dans l'API
function GenerateParam(value){
  params = "";
  if(value.length >= 3 && value.length <= 5 && isNaN(value) === false){
    if(value.length === 3){
      params = params+"code_postal+>%3D+"+value+"00+AND+code_postal+<+";
      value++;
      params = params+value+"00";;
      SearchData(params);
    }else if(value.length === 4){
      params = params+"code_postal+>%3D+"+value+"0+AND+code_postal+<+";
      value++;
      params = params+value+"0";;
      SearchData(params);
    }else if(value.length === 5){
      params = params+"code_postal+%3D+"+value;
      SearchData(params);
    }
  }else{
    closeSuggestBox();
  }
}


// Fonction qui recherche dans l'API en prenant en compte le paramètre de recherche
function SearchData(query){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      results = JSON.parse(this.responseText);
      if(results.nhits > 0){
        suggestBox(results);
      }
    }
  };
  xmlhttp.open("GET", url_api+"&q=" + query + paramsPlus, true);
  xmlhttp.send();
}


// Fonction de tri tableau associatif gérer en mapping
function sortMapByValue(map){
    var tupleArray = [];
    for (var key in map) tupleArray.push([key, map[key]]);
    tupleArray.sort(function (a, b) { return a[1] - b[1] });
    return tupleArray;
}


// Fonction qui génère et affiche la liste des suggestions
function suggestBox(results){
  codes_postaux = {};
  if (results.nhits > 1) {
    // On rend visible la balise dédié à la liste des suggestions
    document.getElementById('suggestBoxElement').style.visibility = 'visible';
    document.getElementById('suggestBoxElement').style.height = '80px';
    var suggestBoxHTML  = '';
    for (i=0; i < 100; i++) {
      // On génère le code html de la liste des suggestions
      if(typeof(results.records[i]) != "undefined"){
        codes_postaux[results.records[i].fields.nom_com] = results.records[i].fields.code_postal;
      }
    }

    // On tri la liste par code postal
    codes_postaux = sortMapByValue(codes_postaux);
    for (var i = 0; i < codes_postaux.length; i++) {
      suggestBoxHTML += "<div class='suggestions' id=pcId" + i + " onmousedown='suggestBoxMouseDown(" + i +
      ")' onmouseover='suggestBoxMouseOver(" +  i +")' onmouseout='suggestBoxMouseOut(" + i +")'>"+
      codes_postaux[i][1] +" "+ codes_postaux[i][0] +'</div>';
    }

    // On écrit le code html de la liste dess suggestions générer précédement dans le balise dédié
    document.getElementById('suggestBoxElement').innerHTML = suggestBoxHTML;
  } else {
    // Si il n'y a qu'une seule suggestion disponible, alors on l'ajoute automatiquement dans le champ "ville"
    if (results.nhits === 1) {
      var placeInput = document.getElementById("ville");
      placeInput.value = results.records[0].fields.nom_com;
      var postalInput = document.getElementById("code_postal");
      postalInput.value = results.records[0].fields.code_postal;
    }
    closeSuggestBox();
  }
}


// fonction qui ferme la liste des suggestions
function closeSuggestBox() {
  document.getElementById('suggestBoxElement').innerHTML = '';
  document.getElementById('suggestBoxElement').style.visibility = 'hidden';
  document.getElementById('suggestBoxElement').style.height = '0px';
}


// On retire le surligne de la suggestion quand la souris n'est plus dessus
function suggestBoxMouseOut(obj) {
  document.getElementById('pcId'+ obj).className = 'suggestions';
}


// On place la suggestion dans le champ "ville" si il est sélectionné, et on ferme la liste des suggestions
function suggestBoxMouseDown(obj) {
  closeSuggestBox();
  var placeInput = document.getElementById("ville");
  placeInput.value = codes_postaux[obj][0];
  var postalInput = document.getElementById("code_postal");
  postalInput.value = codes_postaux[obj][1];
}


// On surligne la suggestion quand la souris est dessus
function suggestBoxMouseOver(obj) {
  document.getElementById('pcId'+ obj).className = 'suggestionMouseOver';
}

*/



/*$("#code_postal").autocomplete({
  source: function (request, response) {
      $.ajax({
          url: "https://api-adresse.data.gouv.fr/search/?postcode="+$("input[name='CODE_POSTAL']").val(),
          data: { q: request.term },
          dataType: "json",
          success: function (data) {
              var postcodes = [];
              response($.map(data.features, function (item) {
                  // Ici on est obligé d'ajouter les code_postal dans un array pour ne pas avoir plusieurs fois le même

                      return { label: item.properties.postcode + " - " + item.properties.city, 
                               city: item.properties.city,
                               value: item.properties.postcode
                               
                      };
                 
              }));
          }
      });
  },
  // On remplit aussi la VILLE
  select: function(event, ui) {
      $('#ville').val(ui.item.city);
  }
});*/

/**
 * Vicopo
 * @author https://github.com/kylekatarnls
 * https://vicopo.selfbuild.fr
 */
 jQuery(function ($) {
  var _host = 'https://vicopo.selfbuild.fr';
  var _cache = {};
  var _sort = function (a, b) {
      return a.city - b.city;
  };
  var _filter = function () {
      return true;
  };
  $.extend({
      vicopoSort: function ($sort) {
          _sort = $sort;
      },
      vicopoFilter: function ($filter) {
          _filter = $filter;
      },
      vicopoPrepare: function ($cities) {
          $cities = $cities.filter(_filter);
          return $cities.sort(_sort);
      },
      vicopo: function (_input, _done) {
          _input = _input.trim();
          return this.getVicopo(/^\d+$/.test(_input) ? 'code' : 'city', _input, _done);
      },
      codePostal: function (_input, _done) {
          return this.getVicopo('code', _input, _done);
      },
      ville: function (_input, _done) {
          return this.getVicopo('city', _input, _done);
      },
      getVicopo: function (_name, _input, _done) {
          if(_input.length > 1) {
              _input = _input.trim();
              _cache[_name] = _cache[_name] || {};

              if(_cache[_name][_input]) {
                  _done(_input, $.vicopoPrepare(_cache[_name][_input] || []), _name);

                  return;
              }

              var _data = {};
              _data[_name] = _input;
              return $.getJSON(_host, _data, function (_answer) {
                  _cache[_name][_input] = _answer.cities;
                  _done(_answer.input, $.vicopoPrepare(_answer.cities || []), _name);
              });
          } else {
              _done(_input, [], _name);
          }
      }
  });
  $.fn.extend({
      vicopoClean: function () {
          return $(this).each(function () {
              var _removeList = [];
              for(var $next = $(this).next(); $next.hasClass('vicopo-answer'); $next = $next.next()) {
                  _removeList.push($next[0]);
              }
              $(_removeList).remove();
          });
      },
      vicopoTargets: function () {
          var _targets = [];
          $(this).each(function () {
              var $target = $(this);
              $('[data-vicopo]').each(function () {
                  if($target.is($(this).data('vicopo'))) {
                      _targets.push(this);
                  }
              });
          });
          return $(_targets);
      },
      vicopoTarget: function () {
          return $(this).vicopoTargets().first();
      },
      vicopoFillField: function (_pattern, _city, _code) {
          return $(this).val(
              _pattern
                  .replace(/(city|ville)/ig, _city)
                  .replace(/(zipcode|code([\s_-]?postal)?)/ig, _code)
          ).vicopoTargets().vicopoClean();
      },
      getVicopo: function (_method, _done) {
          return $(this).keyup(function () {
              var $input = $(this);
              $[_method]($input.val(), function (_input, _cities, _name) {
                  if(_input == $input.val()) {
                      _done(_cities, _name, _input);
                  }
              });
          });
      },
      vicopo: function (_done) {
          return $(this).getVicopo('vicopo', _done);
      },
      codePostal: function (_done) {
          return $(this).getVicopo('codePostal', _done);
      },
      ville: function (_done) {
          return $(this).getVicopo('ville', _done);
      }
  });
  var _fields = 'input, textarea, select';
  $(document).on('keyup change', _fields, function () {
      var $target = $(this);
      var _input = $target.val();
      if($target.data('vicopo-value') !== _input) {
          var _fill = $target.data('vicopo-get');
          var _$targets = $target.data('vicopo-value', _input)
              .vicopoTargets().each(function () {
                  $(this).hide().vicopoClean();
              });
          if(_$targets.length && _input.length) {
              $.vicopo(_input, function (_check, _cities) {
                  if(_check === _input) {
                      _$targets.each(function () {
                          var $repeater = $(this).vicopoClean();
                          var _$template = $repeater.clone();
                          var _click = _$template.data('vicopo-click');
                          _$template.show().removeAttr('data-vicopo');
                          var _$cities = [];
                          $.each(_cities, function () {
                              var $city = _$template.clone();
                              var _code = this.code;
                              var _city = this.city;
                              $city.addClass('vicopo-answer');
                              $city.find('[data-vicopo-code-postal]').text(_code);
                              $city.find('[data-vicopo-ville]').text(_city);
                              $city.find('[data-vicopo-val-code-postal]').val(_code);
                              $city.find('[data-vicopo-val-ville]').val(_city);

                              if (_fill || _click) {
                                  $city.click(function () {
                                      if (_fill) {
                                          $target.vicopoFillField(_fill, _city, _code);
                                      }

                                      $.each(_click, function (_selector, _pattern) {
                                          $(_selector).vicopoFillField(_pattern, _city, _code);
                                      });
                                  });
                              }

                              _$cities.push($city);
                          });
                          $repeater.after(_$cities);
                      });
                  }
              });
          }
      }
  });
  $(_fields).trigger('keyup');
});
