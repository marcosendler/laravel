<x-profile :sharedData="$sharedData">
  <div class="list-group">
    @foreach ($following as $follow)
      <a href="/profile/{{$follow->userFollowing->username}}" class="list-group-item list-group-item-action">
      <img class="avatar-tiny" src="{{$follow->userFollowed->avatar}}" />
      {{$follow->userFollowing->username}}
    @endforeach
  </div>
</div>
</x-profile>