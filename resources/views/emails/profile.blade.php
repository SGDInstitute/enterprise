@component('mail::message')
Hello!

MBLGTACC is coming up! Is all of your profile information up to date?

@component('mail::table')
| | |
| ------------- | :------------: |
| __Name:__ | {{ $user->name }} |
| __Pronouns:__ | {{ $user->profile->pronouns }} |
| __Sexuality:__ | {{ $user->profile->sexuality }} |
| __Gender:__ | {{ $user->profile->gender }} |
| __Race:__ | {{ $user->profile->race }} |
| __College, University or Group:__ | {{ $user->profile->college }} |
| __T-shirt Size:__ | {{ $user->profile->tshirt }} |
| __Accessibility Accommodations:__ | {{ implode(', ', $user->profile->accessibility) }} |
@if($user->profile->other_accessibility)
| __Other Accommodation:__ | {{ $user->profile->other_accessibility }} |
@endif
| __Language Interpretation Services:__ | {{ implode(', ', $user->profile->language) }} |
@if($user->profile->other_language)
| __Other Accommodation:__ | {{ $user->profile->other_language }} |
@endif
@endcomponent

@component('mail::button', ['url' => $url])
Update Profile
@endcomponent

Is the information above correct? If not please update it as soon as possible.

In order to guarentee your tshirt and program book please make sure that your order is paid before January 17th. You will not be able to change your tshirt size after January 17th.

Thanks,<br>
MBLGTACC Planning Team and
Midwest Institute for Sexuality and Gender Diversity
@endcomponent