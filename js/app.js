var WMTU = {};

WMTU.initStream = function(){
  WMTU.streamObject = soundManager.createSound({
    id: 'WMTUStream',
    url: 'http://stream.wmtu.mtu.edu:8000/listen',
    autoLoad: true,
    autoPlay: true,
    volume: 50
  });
};

$(document).ready(function(){
  soundManager.setup({
    url: '/bower_components/soundmanager/swf/',
    preferFlash: false,
    onready: WMTU.initStream
  });
});
