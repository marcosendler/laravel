<x-profile :sharedData="$sharedData">
    <div class="list-group">
      @foreach ($followers as $follow)
        <a href="/profile/{{$follow->userFollowed->username}}" class="list-group-item list-group-item-action">
        <img class="avatar-tiny" src="{{$follow->userFollowed->avatar}}" />
        {{$follow->userFollowing->username}}
      @endforeach
    </div>
  </div>
</x-profile>