var WMTU = {};
WMTU.onStreamPlaying = function(){
  $('#play-button').hide();
  $('#pause-button').show();
};

WMTU.onStreamPaused = function(){
  $('#play-button').show();
  $('#pause-button').hide();
};


WMTU.streamInfoUpdateLoop = function(){
  $.getJSON("http://wmtu.mtu.edu/wp-content/wmtu-custom/djfeed.php", function(data){
    $('#current-track').html(data[0].artist + ' - ' + data[0].song_name + ' |  ' + moment(data[0].ts, "YYYY-MM-DD HH:mm:ss").fromNow())
  });
  setTimeout(WMTU.streamInfoUpdateLoop, 5000);
};

WMTU.initStream = function(){
  WMTU.streamObject = soundManager.createSound({
    id: 'WMTUStream',
    url: 'http://stream.wmtu.mtu.edu:8000/listen',
    autoLoad: true,
    autoPlay: false,
    volume: 80,
    onplay: WMTU.onStreamPlaying,
    onresume: WMTU.onStreamPlaying,
    onpause: WMTU.onStreamPaused
  });
  if(WMTU.streamObject.playState){
    WMTU.onStreamPlaying();
  }else{
    WMTU.onStreamPaused();
  }

};

WMTU.bindThings = function(){
  $('#play-button').click(function(){
    if(WMTU.streamObject.paused){
      WMTU.streamObject.resume();
    } else {
      WMTU.streamObject.play();
    }
  });
  $('#pause-button').click(function(){
    WMTU.streamObject.pause();
  });
  $('#playlist-date').pickadate()
};

WMTU.setup = function(){
  soundManager.setup({
    url: 'bower_components/soundmanager/swf/',
    preferFlash: false,
    onready: WMTU.initStream
  });
  WMTU.bindThings();
  WMTU.streamInfoUpdateLoop();
};

$(document).ready(function(){
  WMTU.setup();
});
