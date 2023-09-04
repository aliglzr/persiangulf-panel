<!--begin::Action--->
<td class="text-end">
{{--    <a href="{{route('templates.show',['slug' => $template->template_slug])}}" class="btn btn-sm btn-light btn-active-light-primary">--}}
{{--        مشاهده--}}
{{--     </a>--}}
    <a href="{{route('viewTemplate',['templatename' => $template->template_slug])}}" class="btn btn-sm btn-light btn-active-light-primary">
        مشاهده
    </a>
    <button onclick="deleteTemplate('{{$template->template_slug}}')" class="btn btn-sm btn-light btn-active-light-danger">
        حذف
    </button>
</td>



