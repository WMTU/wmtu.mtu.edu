---
# Main Javascript file
---

WMTU = window.WMTU = {}
WMTU.onStreamPlaying = ->
  $('#play-button').hide()
  $('#pause-button').show()


WMTU.onStreamPaused = ->
  $('#play-button').show()
  $('#pause-button').hide()

WMTU.handleDatePickerEvent = ->
  $('#playlist-date').blur()
  $("#playlist-table").empty().append "<tr><th>Time</th><th>Artist</th><th>Track Name</th></tr>"
  pickedValue = WMTU.datePicker.get 'select', 'yyyy mm dd'
  if pickedValue != null & pickedValue != ""
    $("#playlist-table").show()

    ymd = pickedValue.split(' ')

    $.post '{{ "/php/playlist.php" | prepend: site.baseurl }}',
      'year':ymd[0]
      'month':ymd[1]
      'day':ymd[2]
      WMTU.renderPlaylist
  else
    $("#playlist-table").hide()

WMTU.renderPlaylist = (data)->
  data = JSON.parse(data)
  for item in data
    row = $("<tr />")
    $("#playlist-table").append(row)
    row.append($("<td>" + moment(item.ts, "YYYY-MM-DD HH:mm:ss").format("h:mm A") + "</td>"))
    row.append($("<td>" + item.artist + "</td>"))
    row.append($("<td>" + item.song_name + "</td>"))


WMTU.streamInfoUpdateLoop = ->
  $.getJSON "{{ "/php/songfeed.php" | prepend: site.baseurl }}", (data)->
    $('#current-track').html data[0].artist + ' - ' + data[0].song_name + ' |  ' + moment(data[0].ts, "YYYY-MM-DD HH:mm:ss").fromNow()

  setTimeout WMTU.streamInfoUpdateLoop, 5000

WMTU.initStream = ->
  WMTU.streamObject = soundManager.createSound
    id: 'WMTUStream',
    url: '{{ site.stream_url }}',
    autoLoad: true,
    autoPlay: false,
    volume: 80,
    onplay: WMTU.onStreamPlaying,
    onresume: WMTU.onStreamPlaying,
    onpause: WMTU.onStreamPaused

  if WMTU.streamObject.playState
    WMTU.onStreamPlaying()
  else
    WMTU.onStreamPaused()

WMTU.bindThings = ->
  $('#play-button').click ->
    if WMTU.streamObject.paused
      WMTU.streamObject.resume()
    else
      WMTU.streamObject.play()

  $('#pause-button').click ->
    WMTU.streamObject.pause()

  WMTU.datePicker = $('#playlist-date').pickadate().pickadate('picker')

  if WMTU.datePicker
    WMTU.datePicker.on
      close: WMTU.handleDatePickerEvent

  $("#playlist-table").hide()

  $(window).scroll ->
    if $(this).scrollTop() > 150 && $(this).scrollTop() < 250
      $("#scrolltotop").css('visibility', 'visible')
    else if $(this).scrollTop() > 250
      $("#scrolltotop").css('visibility', 'visible')
    else
      $("#scrolltotop").css('visibility', 'hidden')

WMTU.setup = ->
  colors = ["rgb(68, 171, 143)", "rgb(254, 196, 0)", "rgb(108, 201, 253)", "rgb(190, 48, 64)"]
  colorsKey = Math.floor(Math.random() * 3)
  nthColor = colors[colorsKey]
  $(".fade-bg").css('background', nthColor)

  soundManager.setup
    url: 'bower_components/soundmanager/swf/',
    preferFlash: false,
    onready: WMTU.initStream

  WMTU.bindThings()
  WMTU.streamInfoUpdateLoop()

  $(document).pjax '[data-pjax] a, a[data-pjax]', '.page-content',
    fragment: '.page-content'

  $(document).on "pjax:timeout", (event)->
    event.preventDefault()

$(document).ready ->
  WMTU.setup()

$(document).on "pjax:success", (event)->
  $("body *").off();
  WMTU.bindThings()
