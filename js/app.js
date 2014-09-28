var WMTU = {};
WMTU.onStreamPlaying = function(){
  $('#play-button').hide();
  $('#pause-button').show();
};

WMTU.onStreamPaused = function(){
  $('#play-button').show();
  $('#pause-button').hide();
};

WMTU.initStream = function(){
  WMTU.streamObject = soundManager.createSound({
    id: 'WMTUStream',
    url: 'http://stream.wmtu.mtu.edu:8000/listen',
    autoLoad: true,
    autoPlay: true,
    volume: 80,
    onplay: WMTU.onStreamPlaying,
    onresume: WMTU.onStreamPlaying,
    onpause: WMTU.onStreamPaused
  });


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
};

WMTU.setup = function(){
  soundManager.setup({
    url: '/bower_components/soundmanager/swf/',
    preferFlash: false,
    onready: WMTU.initStream
  });
  WMTU.bindThings();
};

$(document).ready(function(){
  WMTU.setup();
});
