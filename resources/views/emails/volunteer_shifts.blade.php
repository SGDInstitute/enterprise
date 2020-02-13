@component('mail::message')
Hello {{ $user->name }}!

Thank you again for volunteering at MBLGTACC 2020. Below is a link in a powerpoint that provides instructions for each
role of
volunteering.

@component('mail::button', ['url' =>
'https://docs.google.com/presentation/d/1EKF6pDdAxN9aFtZTDlMg8rboLl2KSlq2n743beiZ_6w/edit?usp=sharing'])
View Powerpoint
@endcomponent

Some quick reminders:
- Wear jeans and a black shirt
- Check-in and -out of your shift at Bernhard 105-107
- Check nametags for pronouns when addressing folks
- At check-in you will receive a bandana to wear on your arm or neck; please return the bandana at the end of your
shift.

@if($activities->count() > 0)

@component('mail::table')
| Shift | Location | Duration |
| ------------- |:-------------:| --------:|
@foreach($activities as $activity)
| {{ $activity->title }} | {{ optional($activity->location)->title }} | {{
$activity->start->timezone('America/Detroit')->format('F j, Y') }} {{
$activity->start->timezone('America/Detroit')->format('g:i a') }} - {{
$activity->end->timezone('America/Detroit')->format('g:i a') }} |
@endforeach
@endcomponent

@else
Please sign up for shifts before coming!

@component('mail::button', ['url' => 'https://apps.sgdinstitute.org/home#volunteering'])
View Available Shifts
@endcomponent

@endif


Thanks for volunteering!<br>
Please reply with questions.
@endcomponent