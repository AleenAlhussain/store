@if(count($apps) >0)
    <table class="table">
        <thead>
        <tr>
            <th><label><input type="checkbox" id="select-all" value="all" class="i-checks"></label></th>
            <th>Cover</th>
            <th>AppId</th>
            <th>Name</th>
        </tr>
        </thead>
        <tbody>

        @foreach($apps as $row)
            <tr>
                <td class="col-md-1">
                    <label id="{{$row->appid}}"><input type="checkbox" value="{{$row->appid}}" class="i-checks"></label>
                </td>
                <td class="col-md-2"><img src="{{ asset('public/images/') }}/{{$row['cover']}}" style="max-width: 40px;"/></td>
                <td class="col-md-3">{{$row->appid}}</td>
                <td class="col-md-6">{{$row->title}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a class="btn btncus notika-btn-black" id="add-apps">Add selected app to collections</a>
    <div class="pagination-inbox text-center">
        {!! $apps->links() !!}
    </div>
@endif
