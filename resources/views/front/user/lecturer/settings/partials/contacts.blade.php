
<div class="tab-pane fade show {{ @$is_active ? 'active' : '' }}" id="{{ @$key }}">

    <form id="form" action="{{route('user.lecturer.settings.update')}}" to="{{ url()->current() }}" method="post">
        @csrf
        <input type="hidden" name="tab" value="contact">
        <div class="row gx-lg-3">
            <div class="form-group col-lg-12">
                <div class="input-icon left">
                    <input class="form-control" placeholder="Twitter" name="twitter" value="{{ @$lecturer->lecturerSetting->twitter }}" type="text" value=""/>
                    <div class="icon text-muted"><i class="fa-brands fa-twitter"></i></div>
                </div>
            </div>
            <div class="form-group col-lg-12">
                <div class="input-icon left">
                    <input class="form-control" placeholder="Facebook" name="facebook" value="{{ @$lecturer->lecturerSetting->facebook }}" type="text" value=""/>
                    <div class="icon text-muted"><i class="fa-brands fa-facebook"></i></div>
                </div>
            </div>
            <div class="form-group col-lg-12">
                <div class="input-icon left">
                    <input class="form-control" placeholder="Instagram" name="instagram" value="{{ @$lecturer->lecturerSetting->instagram }}" type="text" value=""/>
                    <div class="icon text-muted"><i class="fa-brands fa-instagram"></i></div>
                </div>
            </div>
            <div class="form-group col-lg-12">
                <div class="input-icon left">
                    <input class="form-control" placeholder="LinkedIn" name="linkedin" value="{{ @$lecturer->lecturerSetting->linkedin }}" type="text" value=""/>
                    <div class="icon text-muted"><i class="fa-brands fa-linkedin"></i></div>
                </div>
            </div>
            <div class="form-group col-lg-12">
                <div class="input-icon left">
                    <input class="form-control" placeholder="YouTube" name="youtube" value="{{ @$lecturer->lecturerSetting->youtube }}" type="text" value=""/>
                    <div class="icon text-muted"><i class="fa-brands fa-youtube"></i></div>
                </div>
            </div>
        </div>
        @include('front.user.lecturer.courses.new_course.components.save_button')
    </form>

</div>
