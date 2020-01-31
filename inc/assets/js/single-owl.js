jQuery(function($) {
  $(document).ready(function() {
    //Fullscreen fix for mobile browsers
    // First we get the viewport height and we multiple it by 1% to get a value for a vh unit
    var initialinnerHeight = window.innerHeight;
    var initialouterHeight = window.outerHeight;
    let vh = initialinnerHeight * 0.01;
    // Then we set the value in the --vh custom property to the root of the document
    document.documentElement.style.setProperty('--vh', `${vh}px`);

    var id;
    $(window).resize(function() {
      var currentinnerHeight = window.innerHeight;
      var currentouterHeight = window.outerHeight;
      // Only trigger a change if the outer height changes
      if (currentouterHeight != initialouterHeight) {
        let vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
      }
      initialouterHeight = currentouterHeight;
    });
    // end fullscreen fix

    var slider = document.getElementById('range-slider');
    noUiSlider.create(slider, {
      start: 0,
      keyboardSupport: false,
      range: {
        'min': 0,
        'max': 100
      }
    });
    if (window.location.hash) {
      var startHash = window.location.hash.slice(1);
      var hashArray = [];
      $(".owl-carousel .card").each(function(index) {
        hashArray.push($(this).data('hash'));
      });
      var startPosition = hashArray.indexOf(startHash);
    } else {
      var startPosition = 0;
    }
    var owl = $('#single-carousel');
    var currentState = '';
    owl.on('initialized.owl.carousel', function(event) {
      currentState = event;
      sliderSetup(currentState);
    });
    owl.owlCarousel({
      items: 1,
      margin: 30,
      stagePadding: 60,
      nav: false,
      dots: false,
      URLhashListener: true,
      startPosition: startPosition
    });

    owl.on('translated.owl.carousel', function(event) {
      currentState = event;
      sliderDrag(currentState);
    });
    owl.on('resized.owl.carousel', function(event) {
      currentState = event;
      sliderDrag(currentState);
      sliderSetup(currentState);
    });


    function sliderSetup(currentState) {
      pageSize = currentState.page.size;
      itemCount = currentState.item.count;
      coordIndex = itemCount - pageSize - 1;
      if (coordIndex < 0) {
        $('#range-slider').hide();
      } else {
        maxSlider = currentState.relatedTarget._coordinates[coordIndex];
        currentIndex = currentState.item.index;
        if (currentIndex == 0) {
          currentValue = 0;
        } else {
          currentValue = Math.abs(currentState.relatedTarget._coordinates[currentIndex - 1]);
        }
        // Create list of dates and coordinates for tooltip and decade markers
        var dateArray = [];
        $(".owl-item .card").each(function(index) {
          dateArray.push($(this).data('datestart'));
        });
        var coordListMarker = [0].concat(currentState.relatedTarget._coordinates);

        slider.noUiSlider.updateOptions({
          start: currentValue,
          tooltips: {
            to: function(value) {
              var closestCoor = coordListMarker.reduce(function(prev, curr) {
                return (Math.abs(Math.abs(curr) - value) < Math.abs(Math.abs(prev) - value) ? curr : prev);
              });
              var coorIndex = coordListMarker.indexOf(closestCoor);
              return dateArray[coorIndex];
            }
          },
          range: {
            'min': 0,
            'max': Math.abs(maxSlider)
          }
        });
        // Set up date markers
        var decadeArrayObject = [];
        var prevDecade = '';
        var currentYear = '';
        var currentDecade = '';
        for (var x in dateArray) {
          dateObject = {};
          currentYear = dateArray[x].toString();
          currentDecade = currentYear.substr(0, 3) + '0s';
          if (currentDecade != prevDecade) {
            dateObject.value = currentDecade;
            if ((Math.abs(coordListMarker[x])) > (Math.abs(maxSlider))) {
              dateObject.coordinate = maxSlider;
            } else {
              dateObject.coordinate = coordListMarker[x];
            }
            decadeArrayObject.push(dateObject);
            // set current
            prevDecade = currentDecade;
          }
        }
        // delete old markers
        $('.date-marker').detach();
        // add new markers and create linear gradient for slider background
        var gradient = 'linear-gradient(to right';
        var decadeCount = decadeArrayObject.length;
        for (var x in decadeArrayObject) {
          var percentLeft = (Math.abs(decadeArrayObject[x].coordinate) / Math.abs(maxSlider)) * 100;
          $('#range-slider').append(
            '<div class="date-marker px-1" style="left: ' + percentLeft + '%;">' + decadeArrayObject[x].value + '</div>'
          );
          // Previous color create hard stops in gradient
          if (x != 0) {
            var prevTransparency = (Number(x)) / decadeCount;
            var prevColor = 'rgba(168, 2, 2, ' + prevTransparency + ')'
            gradient += ', ' + prevColor + ' ' + percentLeft + '%';
          }
          var transparency = (Number(x) + 1) / decadeCount;
          var color = 'rgba(168, 2, 2, ' + transparency + ')'
          gradient += ', ' + color + ' ' + percentLeft + '%';
        }
        gradient += ')';
        $('#range-slider').css("background-image", gradient);
        // Remove overlaps
        var rectList = [];
        var currentRect = '';
        $('.date-marker').each(function(index) {
          currentRect = this.getBoundingClientRect();
          if (!jQuery.isEmptyObject(rectList)) {
            if (checkforoverlap(currentRect, rectList)) {
              $(this).detach();
            } else {
              rectList.push(currentRect);
            }
          } else {
            rectList.push(currentRect);
          }
        });
      }
    };

    function checkforoverlap(currentRect, rectList) {
      for (var x in rectList) {
        var overlap = !(currentRect.right < rectList[x].left ||
          currentRect.left > rectList[x].right ||
          currentRect.bottom < rectList[x].top ||
          currentRect.top > rectList[x].bottom);
        if (overlap) {
          return true;
        }
      }
    }

    function sliderDrag(currentState) {
      matrix = $('#single-carousel .owl-stage').css("transform").replace(/[^0-9\-.,]/g, '').split(',');
      xShift = matrix[12] || matrix[4];
      slider.noUiSlider.set(Math.abs(xShift));
    }
    // Move Timeline by moving range input
    slider.noUiSlider.on('update', function(values, handle) {
      rangeShift = values[handle];
      $('#single-carousel .owl-stage').css({
        "transform": "translate3d(" + -rangeShift + "px, 0px, 0px)",
        "transition": 'all 0s ease 0s'
      });
    });
    // Move Timeline to the Appropriate Item Based on Nearest Position
    slider.noUiSlider.on('change', function(values, handle) {
      currentMatrix = $('#single-carousel .owl-stage').css("transform").replace(/[^0-9\-.,]/g, '').split(',');
      currentxShift = currentMatrix[12] || currentMatrix[4];
      coordList = [0].concat(currentState.relatedTarget._coordinates);
      var closest = coordList.reduce(function(prev, curr) {
        return (Math.abs(curr - currentxShift) < Math.abs(prev - currentxShift) ? curr : prev);
      });
      var itemIndex = coordList.indexOf(closest);
      owl.trigger('to.owl.carousel', itemIndex);
      $('#single-carousel .owl-stage').css({
        "transition": 'all .25s ease 0s'
      });
    });
    // Go to the next item
    $('#next').click(function() {
      owl.trigger('next.owl.carousel');
    });
    // Go to the previous item
    $('#previous').click(function() {
      // With optional speed parameter
      // Parameters has to be in square bracket '[]'
      owl.trigger('prev.owl.carousel');
    });

  });
});