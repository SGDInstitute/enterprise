<div class="bg-white rounded shadow overflow-hidden">
    <nav class="bg-mint-200 px-8 pt-2 border-b border-mint-300">
        <div class="-mb-px flex nav nav-tabs material-nav" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
            <a class="nav-item nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false">Password</a>
        </div>
    </nav>
    <div class="tab-content p-6" id="nav-tabContent">
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <edit-profile :user="{{ auth()->user() }}" :profile="{{ auth()->user()->profile }}"></edit-profile>
        </div>

        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
            <edit-password></edit-password>
        </div>
    </div>
</div>