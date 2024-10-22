@extends('front.layouts.index', ['is_active' => 'show_mettings', 'sub_title' => __('show_mettings')])
@section('content')
@push('front_css')
    <style>
        .meeting-tools button {
            padding: 5px;
            text-align: center;
            margin: 3px;
            background-color: #eee;
            border-radius: 50%;
            width: 30px;
            height: 30px;
        }

        .meeting-tools button.success-bg {
            background-color: #07b882;
        }


        .meeting-tools button.danger-bg {
            background-color: #ea3e09;
        }
    </style>
@endpush
<section class="section wow fadeInUp" data-wow-delay="0.1s">

    <div class="bg-white p-4 rounded-4 border-primary">
        <div class="row">

            <div class="col-12">
                <h2 class="font-medium text-center mb-3">
                    {{ __('show_mettings') }} ({{@$private_lesson->category->name}}) -
                    {{@$private_lesson->teacher->name}}
                </h2>
            </div>

            <div class="col-12">
                <input id="appid" type="hidden" value="{{$meeting->app_id}}" readonly>
                <input id="token" type="hidden" value="{{$meeting->token}}" readonly>
                <input id="channel" type="hidden" value="{{$meeting->channel}}" readonly>
                <input id="urlId" type="hidden" value="{{$meeting->url}}" readonly>
                <input id="event" type="hidden" value="{{@$event}}" readonly>







            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="other-info shadow- rounded bg-white p-3">


                    <div class="meeting-tools">

                        <button type="button" class="success-bg" type="button" id="join">
                            <i class="fa-solid fa-right-to-bracket"></i>
                        </button>

                        <button type="button" type="button" id="camera" style="display:none">
                            <i class="fa-solid fa-camera camera-on-icon" style="display: none;"></i>
                            <i class="fa-solid fa-camera-slash camera-off-icon" style="display: none;"></i>
                        </button>

                        <button type="button" type="button" id="microphone" style="display: none;">
                            <i class="fa-solid fa-microphone microphone-on-icon" style="display: none;"></i>
                            <i class="fa-solid fa-microphone-slash microphone-off-icon" style="display: none;"></i>
                        </button>


                        <button type="button" class="danger-bg" type="button" id="leave" style="display:none">
                            <i class="fa-solid fa-right-to-bracket"></i>
                        </button>



                    </div>

                    <div class="row" id="video">

                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

@push('front_js')

    <script src="https://cdn.jsdelivr.net/npm/agora-rtc-sdk-ng@4.21.0/AgoraRTC_N-production.min.js"></script>
    <script>

        function randomIntFromInterval(min, max) { // min and max included
            return Math.floor(Math.random() * (max - min + 1) + min)
        }

        const APP_ID = $('#appid').val();
        const TOKEN = $('#token').val();
        const CHANNEL = $('#channel').val();


        let rtc = {
            // For the local audio and video tracks.
            localAudioTrack: null,
            localVideoTrack: null,
            client: null,
        };

        let options = {
            // Pass your app ID here.
            appId: APP_ID,
            // Set the channel name.
            channel: CHANNEL,
            // Use a temp token
            token: TOKEN,
            // Uid
            uid: "{{auth()->user()->id}}",
            userName: "{{auth()->user()->name}}",
            userImage: "{{imageUrl(auth()->user()->image)}}"
        };

        async function startBasicCall() {
            // Create an AgoraRTCClient object.
            rtc.client = AgoraRTC.createClient({ mode: "rtc", codec: "vp8" });
            // Listen for the "user-published" event, from which you can get an AgoraRTCRemoteUser object.
            rtc.client.on("user-published", async (user, mediaType) => {
                // Subscribe to the remote user when the SDK triggers the "user-published" event
                await rtc.client.subscribe(user, mediaType);
                console.log("subscribe success");
                // If the remote user publishes a video track.
                if (mediaType === "video") {
                    // Get the RemoteVideoTrack object in the AgoraRTCRemoteUser object.
                    const remoteVideoTrack = user.videoTrack;
                    // Dynamically create a container in the form of a DIV element for playing the remote video track.
                    const remotePlayerContainer = document.createElement("div");
                    // Specify the ID of the DIV container. You can use the UID of the remote user.
                    remotePlayerContainer.id = user.uid.toString();
                    remotePlayerContainer.textContent = "Remote user " + user.uid.toString();
                    remotePlayerContainer.style.width = "640px";
                    remotePlayerContainer.style.height = "480px";
                    document.getElementById('video').append(remotePlayerContainer);
                    // Play the remote video track.
                    // Pass the DIV container and the SDK dynamically creates a player in the container for playing the remote video track.
                    remoteVideoTrack.play(remotePlayerContainer);
                }
                // If the remote user publishes an audio track.
                if (mediaType === "audio") {
                    // Get the RemoteAudioTrack object in the AgoraRTCRemoteUser object.
                    const remoteAudioTrack = user.audioTrack;
                    // Play the remote audio track. No need to pass any DOM element.
                    remoteAudioTrack.play();
                }
                // Listen for the "user-unpublished" event
                rtc.client.on("user-unpublished", user => {
                    // Get the dynamically created DIV container.
                    const remotePlayerContainer = document.getElementById(user.uid);
                    // Destroy the container.
                    remotePlayerContainer.remove();
                });
            });
            window.onload = function () {
                document.getElementById("join").onclick = async function () {
                    // Join an RTC channel.
                    await rtc.client.join(options.appId, options.channel, options.token, options.uid);
                    // Create a local audio track from the audio sampled by a microphone.
                    rtc.localAudioTrack = await AgoraRTC.createMicrophoneAudioTrack();
                    // Create a local video track from the video captured by a camera.
                    rtc.localVideoTrack = await AgoraRTC.createCameraVideoTrack();
                    // Publish the local audio and video tracks to the RTC channel.
                    await rtc.client.publish([rtc.localAudioTrack, rtc.localVideoTrack]);
                    // Dynamically create a container in the form of a DIV element for playing the local video track.
                    const localPlayerContainer = document.createElement("div");
                    // Specify the ID of the DIV container. You can use the UID of the local user.
                    localPlayerContainer.id = options.uid;
                    localPlayerContainer.textContent = options.userName;
                    // localPlayerContainer.style.width = "640px";
                    localPlayerContainer.className = "col-md-6 mt-3";
                    localPlayerContainer.style.height = "350px";
                    document.getElementById('video').append(localPlayerContainer);
                    // Play the local video track.
                    // Pass the DIV container and the SDK dynamically creates a player in the container for playing the local video track.
                    rtc.localVideoTrack.play(localPlayerContainer);
                    console.log("publish success!");

                    $('#leave').show();
                    $('#camera').show();
                    $('#microphone').show();
                    $('#join').hide();

                    //check camera 
                    if (!rtc.localVideoTrack.muted) {
                        $('.camera-on-icon').show();
                        $('.camera-off-icon').hide();
                    } else {
                        $('.camera-off-icon').show();
                        $('.camera-on-icon').hide();
                    }

                    //check 
                    if (!rtc.localAudioTrack.muted) {
                        $('.microphone-on-icon').show();
                        $('.microphone-off-icon').hide();
                    } else {
                        $('.microphone-off-icon').show();
                        $('.microphone-on-icon').hide();
                    }
                };
                document.getElementById("leave").onclick = async function () {
                    // Destroy the local audio and video tracks.
                    rtc.localAudioTrack.close();
                    rtc.localVideoTrack.close();
                    // Remove the container for the local video track.
                    const localPlayerContainer = document.getElementById(options.uid);
                    if (localPlayerContainer) {
                        localPlayerContainer.remove();
                    }
                    // Traverse all remote users to remove remote containers
                    rtc.client.remoteUsers.forEach(user => {
                        // Destroy the dynamically created DIV containers.
                        const playerContainer = document.getElementById(user.uid);
                        playerContainer && playerContainer.remove();
                    });
                    // Leave the channel.
                    await rtc.client.leave();

                    $('#leave').hide();
                    $('#camera').hide();
                    $('#microphone').hide();
                    $('#join').show();
                };


                document.getElementById("camera").onclick = async function () {

                    if (rtc.localVideoTrack.muted) {
                        await rtc.localVideoTrack.setMuted(false);
                        $('.camera-on-icon').show();
                        $('.camera-off-icon').hide();


                    } else {
                        await rtc.localVideoTrack.setMuted(true);
                        $('.camera-off-icon').show();
                        $('.camera-on-icon').hide();
                    }


                };

                document.getElementById("microphone").onclick = async function () {

                    if (rtc.localAudioTrack.muted) {
                        await rtc.localAudioTrack.setMuted(false);
                        $('.microphone-on-icon').show();
                        $('.microphone-off-icon').hide();


                    } else {
                        await rtc.localAudioTrack.setMuted(true);
                        $('.microphone-off-icon').show();
                        $('.microphone-on-icon').hide();
                    }


                };




            };
        }
        startBasicCall();




    </script>

@endpush
@endsection