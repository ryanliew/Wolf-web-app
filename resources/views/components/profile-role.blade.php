<li class="margin-1" style="max-width:100px">
	{{ trans('roles.' . $role->slug) }}
	<img class="img-responsive img-circle margin-1" src="{{ $role->avatar_path }}">
	机率: {{ round($user->getRateForRole($role->id), 0) }}%<br>
	胜率: {{ round($user->getWinRateForRole($role->id), 0) }}%<br>
	{{ $user->getWinCountForRole($role->id) }}/{{ $user->getCountForRole($role->id) }}
</li>