@extends('layouts.dashboard')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
        </ol>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="profile card card-body px-3 pt-3 pb-0">
                    <div class="profile-head">
                        <div class="photo-content">
                            <div class="cover-photo">
                                @if (Auth::user()->cover_photo == null)
                                    ''
                                @else
                                    <img src="{{ asset('uploads/user/' . Auth::user()->cover_photo) }}" alt="cover_photo"
                                        width="1070" height=400">
                                @endif
                            </div>
                        </div>
                        <div class="profile-info">
                            <div class="profile-photo">
                                @if (Auth::user()->image == null)
                                    <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" alt=""
                                        width="100" height=100" />
                                @else
                                    <img src="{{ asset('uploads/user/' . Auth::user()->image) }}" alt="profile-photo"
                                        width="100" height=100" style="border-radius: 50%" />
                                @endif
                            </div>
                            <div class="profile-details">
                                <div class="profile-name px-3 pt-2">
                                    <h3 class="text-primary mb-0">{{ Auth::user()->name }}</h3>
                                    <p>UX / UI Designer</p>
                                </div>
                                <div class="profile-email px-2 pt-1 mt-2">
                                    <h4 class="text-muted mb-0">{{ Auth::user()->email }}</h4>
                                    <p>Email</p>
                                </div>
                                <div class="dropdown ml-auto">
                                    <a href="#" class="btn btn-primary light sharp" data-toggle="dropdown"
                                        aria-expanded="true"><svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <circle fill="#000000" cx="5" cy="12" r="2">
                                                </circle>
                                                <circle fill="#000000" cx="12" cy="12" r="2">
                                                </circle>
                                                <circle fill="#000000" cx="19" cy="12" r="2">
                                                </circle>
                                            </g>
                                        </svg></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li class="dropdown-item"><i class="fa fa-user-circle text-primary mr-2"></i> View
                                            profile</li>
                                        <li class="dropdown-item"><i class="fa fa-users text-primary mr-2"></i> Add to close
                                            friends</li>
                                        <li class="dropdown-item"><i class="fa fa-plus text-primary mr-2"></i> Add to group
                                        </li>
                                        <li class="dropdown-item"><i class="fa fa-ban text-primary mr-2"></i> Block</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-statistics">
                            <div class="text-center">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="m-b-0">150</h3><span>Follower</span>
                                    </div>
                                    <div class="col">
                                        <h3 class="m-b-0">140</h3><span>Place Stay</span>
                                    </div>
                                    <div class="col">
                                        <h3 class="m-b-0">45</h3><span>Reviews</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="sendMessageModal">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Send Message</h5>
                                            <button type="button" class="close"
                                                data-dismiss="modal"><span>&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="comment-form">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="text-black font-w600">Name <span
                                                                    class="required">*</span></label>
                                                            <input type="text" class="form-control" value="Author"
                                                                name="Author" placeholder="Author">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="text-black font-w600">Email <span
                                                                    class="required">*</span></label>
                                                            <input type="text" class="form-control" value="Email"
                                                                placeholder="Email" name="Email">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="text-black font-w600">Comment</label>
                                                            <textarea rows="8" class="form-control" name="comment" placeholder="Comment"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-0">
                                                            <input type="submit" value="Post Comment"
                                                                class="submit btn btn-primary" name="submit">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-xl-10">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs mb-3">
                                    <li class="nav-item"><a href="#my-posts" data-toggle="tab" class="nav-link">Posts</a>
                                    </li>
                                    <li class="nav-item"><a href="#about-me" data-toggle="tab" class="nav-link">About
                                            Me</a>
                                    </li>
                                    <li class="nav-item"><a href="#profile-settings" data-toggle="tab"
                                            class="nav-link active show">Account Settings</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="my-posts" class="tab-pane fade">
                                        <div class="my-post-content pt-3">
                                            <div class="post-input">
                                                <textarea name="textarea" id="textarea" cols="30" rows="5" class="form-control bg-transparent"
                                                    placeholder="Please type what you want...."></textarea>
                                                <a href="javascript:void()" class="btn btn-primary light px-3"><i
                                                        class="fa fa-link"></i> </a>
                                                <a href="javascript:void()" class="btn btn-primary light mr-1 px-3"><i
                                                        class="fa fa-camera"></i> </a><a href="javascript:void()"
                                                    class="btn btn-primary">Post</a>
                                            </div>
                                            <div class="profile-uoloaded-post border-bottom-1 pb-5">
                                                <img src="images/profile/8.jpg" alt="" class="img-fluid">
                                                <a class="post-title" href="post-details.html">
                                                    <h3 class="text-black">Collection of textile samples lay spread</h3>
                                                </a>
                                                <p>A wonderful serenity has take possession of my entire soul like these
                                                    sweet morning of spare which enjoy whole heart.A wonderful serenity has
                                                    take possession of my entire soul like these sweet morning
                                                    of spare which enjoy whole heart.</p>
                                                <button class="btn btn-primary mr-2"><span class="mr-2"><i
                                                            class="fa fa-heart"></i></span>Like</button>
                                                <button class="btn btn-secondary" data-toggle="modal"
                                                    data-target="#replyModal"><span class="mr-2"><i
                                                            class="fa fa-reply"></i></span>Reply</button>
                                            </div>
                                            <div class="profile-uoloaded-post border-bottom-1 pb-5">
                                                <img src="images/profile/9.jpg" alt="" class="img-fluid">
                                                <a class="post-title" href="post-details.html">
                                                    <h3 class="text-black">Collection of textile samples lay spread</h3>
                                                </a>
                                                <p>A wonderful serenity has take possession of my entire soul like these
                                                    sweet morning of spare which enjoy whole heart.A wonderful serenity has
                                                    take possession of my entire soul like these sweet morning
                                                    of spare which enjoy whole heart.</p>
                                                <button class="btn btn-primary mr-2"><span class="mr-2"><i
                                                            class="fa fa-heart"></i></span>Like</button>
                                                <button class="btn btn-secondary" data-toggle="modal"
                                                    data-target="#replyModal"><span class="mr-2"><i
                                                            class="fa fa-reply"></i></span>Reply</button>
                                            </div>
                                            <div class="profile-uoloaded-post pb-3">
                                                <img src="images/profile/8.jpg" alt="" class="img-fluid">
                                                <a class="post-title" href="post-details.html">
                                                    <h3 class="text-black">Collection of textile samples lay spread</h3>
                                                </a>
                                                <p>A wonderful serenity has take possession of my entire soul like these
                                                    sweet morning of spare which enjoy whole heart.A wonderful serenity has
                                                    take possession of my entire soul like these sweet morning
                                                    of spare which enjoy whole heart.</p>
                                                <button class="btn btn-primary mr-2"><span class="mr-2"><i
                                                            class="fa fa-heart"></i></span>Like</button>
                                                <button class="btn btn-secondary" data-toggle="modal"
                                                    data-target="#replyModal"><span class="mr-2"><i
                                                            class="fa fa-reply"></i></span>Reply</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="about-me" class="tab-pane fade">
                                        <div class="profile-about-me">
                                            <div class="pt-4 border-bottom-1 pb-3">
                                                <h4 class="text-primary">About Me</h4>
                                                <p class="mb-2">A wonderful serenity has taken possession of my entire
                                                    soul, like these sweet mornings of spring which I enjoy with my whole
                                                    heart. I am alone, and feel the charm of existence was created for the
                                                    bliss of souls like mine.I am so happy, my dear friend, so absorbed in
                                                    the exquisite sense of mere tranquil existence, that I neglect my
                                                    talents.</p>
                                                <p>A collection of textile samples lay spread out on the table - Samsa was a
                                                    travelling salesman - and above it there hung a picture that he had
                                                    recently cut out of an illustrated magazine and housed in a nice, gilded
                                                    frame.</p>
                                            </div>
                                        </div>
                                        <div class="profile-skills mb-5">
                                            <h4 class="text-primary mb-2">Skills</h4>
                                            <a href="javascript:void()"
                                                class="btn btn-primary light btn-xs mb-1">Admin</a>
                                            <a href="javascript:void()"
                                                class="btn btn-primary light btn-xs mb-1">Dashboard</a>
                                            <a href="javascript:void()"
                                                class="btn btn-primary light btn-xs mb-1">Photoshop</a>
                                            <a href="javascript:void()"
                                                class="btn btn-primary light btn-xs mb-1">Bootstrap</a>
                                            <a href="javascript:void()"
                                                class="btn btn-primary light btn-xs mb-1">Responsive</a>
                                            <a href="javascript:void()"
                                                class="btn btn-primary light btn-xs mb-1">Crypto</a>
                                        </div>
                                        <div class="profile-lang  mb-5">
                                            <h4 class="text-primary mb-2">Language</h4>
                                            <a href="javascript:void()" class="text-muted pr-3 f-s-16"><i
                                                    class="flag-icon flag-icon-us"></i> English</a>
                                            <a href="javascript:void()" class="text-muted pr-3 f-s-16"><i
                                                    class="flag-icon flag-icon-fr"></i> French</a>
                                            <a href="javascript:void()" class="text-muted pr-3 f-s-16"><i
                                                    class="flag-icon flag-icon-bd"></i> Bangla</a>
                                        </div>
                                        <div class="profile-personal-info">
                                            <h4 class="text-primary mb-4">Personal Information</h4>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">Name <span class="pull-right">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7"><span>Mitchell C.Shay</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">Email <span class="pull-right">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7"><span>example@examplel.com</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">Availability <span class="pull-right">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7"><span>Full Time (Free Lancer)</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">Age <span class="pull-right">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7"><span>27</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">Location <span class="pull-right">:</span></h5>
                                                </div>
                                                <div class="col-sm-9 col-7"><span>Rosemont Avenue Melbourne,
                                                        Florida</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-3 col-5">
                                                    <h5 class="f-w-500">Year Experience <span class="pull-right">:</span>
                                                    </h5>
                                                </div>
                                                <div class="col-sm-9 col-7"><span>07 Year Experiences</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="profile-settings" class="tab-pane fade active show">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h3 class="text-primary">General Infos</h3>
                                                            <form class="mt-2" action="{{ route('profile.update') }}"
                                                                method="POST">
                                                                @csrf
                                                                <label class="mt-4 text-primary">Name</label>
                                                                <input type="text" name="name"
                                                                    placeholder="Update Name"
                                                                    value="{{ Auth::user()->name }}"
                                                                    class="form-control text-black">
                                                                <label class="mt-4 text-primary">Email</label>
                                                                <input type="email" name="email"
                                                                    placeholder="Update Email"
                                                                    value="{{ Auth::user()->email }}"
                                                                    class="form-control text-black mb-1">
                                                                <button class="btn btn-primary mt-4" type="submit">Update
                                                                    Info</button>
                                                            </form>
                                                        </div>
                                                        <div class="form-group mt-5 px-0">
                                                            <h3 class="text-primary">Security Info</h3>
                                                            <form class="mt-2" action="{{ route('pass.update') }}"
                                                                method="POST">
                                                                @csrf
                                                                <label class="mt-4 text-primary">Old Password</label>
                                                                <input type="password" name="old_password"
                                                                    placeholder="Old Password"
                                                                    class="form-control text-black">
                                                                @error('old_password')
                                                                    <strong class="text-danger"
                                                                        style="display: block">{{ $message }}</strong>
                                                                @enderror
                                                                <label class="mt-4 text-primary">New Password</label>
                                                                <input type="password" name="password"
                                                                    placeholder="New Password"
                                                                    class="form-control text-black">
                                                                @error('password')
                                                                    <strong class="text-danger"
                                                                        style="display: block">{{ $message }}</strong>
                                                                @enderror
                                                                <label class="mt-4 text-primary">Confirm Password</label>
                                                                <input type="password" name="password_confirmation"
                                                                    placeholder="Confirm Password"
                                                                    class="form-control text-black">
                                                                @error('password_confirmation')
                                                                    <strong class="text-danger"
                                                                        style="display: block">{{ $message }}</strong>
                                                                @enderror

                                                                <button class="btn btn-primary mt-4" type="submit">Update
                                                                    Password</button>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h3 class="text-primary mb-2">Change Profile Picture</h3>
                                                            <form class="mt-2 mb-2"
                                                                action="{{ route('picture.update') }}" method="POST"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="file" name="profile_picture"
                                                                    class="mt-4 mb-2 text-black">
                                                                @error('profile_picture')
                                                                    <strong class="text-danger"
                                                                        style="display: block">{{ $message }}</strong>
                                                                @enderror
                                                                <button class="btn btn-primary mt-4" type="submit">Upload
                                                                    Photo</button>
                                                            </form>
                                                        </div>
                                                        <div class="form-group mt-5">
                                                            <h3 class="text-primary mb-2">Change Cover Photo</h3>
                                                            <form class="mt-2"
                                                                action="{{ route('cover.photo.update') }}" method="POST"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="file" name="cover_photo"
                                                                    class="mt-4 mb-2 text-black">
                                                                @error('cover_photo')
                                                                    <strong class="text-danger"
                                                                        style="display: block">{{ $message }}</strong>
                                                                @enderror
                                                                <button class="btn btn-primary mt-4" type="submit">Upload
                                                                    Photo</button>
                                                            </form>

                                                        </div>



                                                    </div>
                                                </div>
                                                {{-- <div class="form-group col-md-6">
                                                    <label>Password</label>
                                                    <input type="password" placeholder="Password" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input type="text" placeholder="1234 Main St"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Address 2</label>
                                                    <input type="text" placeholder="Apartment, studio, or floor"
                                                        class="form-control">
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>City</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>State</label>
                                                        <select class="form-control default-select" id="inputState">
                                                            <option selected="">Choose...</option>
                                                            <option>Option 1</option>
                                                            <option>Option 2</option>
                                                            <option>Option 3</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label>Zip</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="gridCheck">
                                                        <label class="custom-control-label" for="gridCheck"> Check me
                                                            out</label>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Sign
                                                    in</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="replyModal">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Post Reply</h5>
                                            <button type="button" class="close"
                                                data-dismiss="modal"><span>&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <textarea class="form-control" rows="4">Message</textarea>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger light"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Reply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerBody')
    @if (session('updateInfoSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('updateInfoSuccess') }}",
                'success'
            )
        </script>
    @endif

    @if (session('updatePassSuccess'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Done!',
                text: '{{ session('updatePassSuccess') }}',
            })
        </script>
    @endif

    @if (session('updatePassErr'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('updatePassErr') }}',
                footer: '<a href="">Forgot Password?</a>'
            })
        </script>
    @endif


    @if (session('updateDPSuccess'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Done!',
                text: '{{ session('updateDPSuccess') }}',
            })
        </script>
    @endif

    @if (session('updateCoverSuccess'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Done!',
                text: '{{ session('updateCoverSuccess') }}',
            })
        </script>
    @endif
@endsection
