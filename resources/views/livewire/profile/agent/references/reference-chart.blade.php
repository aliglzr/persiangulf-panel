<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
         data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">معرفی شدگان</h3>
        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Content-->
    <div id="agent_references" class="collapse show">
        <!--begin::Form-->
        <div class="form fv-plugins-bootstrap5 fv-plugins-framework">
            <!--begin::Card body-->
            <div class="card-body border-top p-9" dir="ltr">
                <div id="chartdiv" style="width: 100%;height: 300px;"></div>
            </div>
            <!--end::Card body-->
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
@push('scripts')
    <script src="//cdn.amcharts.com/lib/5/index.js"></script>
    <script src="//cdn.amcharts.com/lib/5/hierarchy.js"></script>
    <script src="//cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script>
        /**
         * ---------------------------------------
         * This demo was created using amCharts 5.
         *
         * For more information visit:
         * https://www.amcharts.com/
         *
         * Documentation is available at:
         * https://www.amcharts.com/docs/v5/
         * ---------------------------------------
         */

// Create root and chart
        var root = am5.Root.new("chartdiv");

        root.setThemes([
            am5themes_Animated.new(root)
        ]);

        var data = [{
            name: "شما",
            children: [{
                name: "A0",
                children: [{
                    name: "A00",
                    value: 88
                }, {
                    name: "A01",
                    value: 23
                }, {
                    name: "A02",
                    value: 25
                }]
            }, {
                name: "B0",
                children: [{
                    name: "B10",
                    value: 62
                }, {
                    name: "B11",
                    value: 4
                }]
            }, {
                name: "C0",
                children: [{
                    name: "C20",
                    value: 11
                }, {
                    name: "C21",
                    value: 92
                }, {
                    name: "C22",
                    value: 17
                }]
            }, {
                name: "D0",
                children: [{
                    name: "D30",
                    value: 95
                }, {
                    name: "D31",
                    value: 84
                }, {
                    name: "D32",
                    value: 75
                }]
            }]
        }];


        var container = root.container.children.push(
            am5.Container.new(root, {
                width: am5.percent(100),
                height: am5.percent(100),
                addClassName : true,
                layout: root.verticalLayout
            })
        );

        container.children.unshift(am5.Label.new(root,{
            text: "نمایش لیست زیرمجموعه ها",
            fontSize: 25,
            fontWeight: "500",
            fontFamily : 'YekanBakh',
            textAlign: "center",
            x: am5.percent(50),
            centerX: am5.percent(50),
            paddingTop: 0,
            paddingBottom: 15
        }))
        $(".amcharts-title-main").css("font-family", "YekanBakh");
        var series = container.children.push(
            am5hierarchy.Tree.new(root, {
                singleBranchOnly: false,
                downDepth: 1,
                initialDepth: 5,
                topDepth: 0,
                valueField: "value",
                categoryField: "name",
                childDataField: "children"
            })
        );

        series.circles.template.setAll({
            radius: 20,
        });

        series.outerCircles.template.setAll({
            radius: 20
        });

        series.data.setAll(data);
        series.set("selectedDataItem", series.dataItems[0]);
        // series.set("tooltipText", "[fontFamily: YekanBakh]I'm a robot![/]");
    </script>
@endpush