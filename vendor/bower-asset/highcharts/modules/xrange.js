/*
 Highcharts JS v9.1.0 (2021-05-03)

 X-range series

 (c) 2010-2021 Torstein Honsi, Lars A. V. Cabrera

 License: www.highcharts.com/license
*/
(function(a){"object"===typeof module&&module.exports?(a["default"]=a,module.exports=a):"function"===typeof define&&define.amd?define("highcharts/modules/xrange",["highcharts"],function(g){a(g);a.Highcharts=g;return a}):a("undefined"!==typeof Highcharts?Highcharts:void 0)})(function(a){function g(a,e,h,b){a.hasOwnProperty(e)||(a[e]=b.apply(null,h))}a=a?a._modules:{};g(a,"Series/XRange/XRangePoint.js",[a["Core/Series/Point.js"],a["Core/Series/SeriesRegistry.js"],a["Core/Utilities.js"]],function(a,
e,h){var b=this&&this.__extends||function(){var a=function(c,d){a=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(a,d){a.__proto__=d}||function(a,d){for(var c in d)d.hasOwnProperty(c)&&(a[c]=d[c])};return a(c,d)};return function(c,d){function b(){this.constructor=c}a(c,d);c.prototype=null===d?Object.create(d):(b.prototype=d.prototype,new b)}}();h=h.extend;e=function(e){function c(){var a=null!==e&&e.apply(this,arguments)||this;a.options=void 0;a.series=void 0;return a}b(c,e);c.getColorByCategory=
function(a,c){var d=a.options.colors||a.chart.options.colors;a=c.y%(d?d.length:a.chart.options.chart.colorCount);return{colorIndex:a,color:d&&d[a]}};c.prototype.resolveColor=function(){var a=this.series;if(a.options.colorByPoint&&!this.options.color){var b=c.getColorByCategory(a,this);a.chart.styledMode||(this.color=b.color);this.options.colorIndex||(this.colorIndex=b.colorIndex)}else this.color||(this.color=a.color)};c.prototype.init=function(){a.prototype.init.apply(this,arguments);this.y||(this.y=
0);return this};c.prototype.setState=function(){a.prototype.setState.apply(this,arguments);this.series.drawPoint(this,this.series.getAnimationVerb())};c.prototype.getLabelConfig=function(){var d=a.prototype.getLabelConfig.call(this),c=this.series.yAxis.categories;d.x2=this.x2;d.yCategory=this.yCategory=c&&c[this.y];return d};c.prototype.isValid=function(){return"number"===typeof this.x&&"number"===typeof this.x2};return c}(e.seriesTypes.column.prototype.pointClass);h(e.prototype,{tooltipDateKeys:["x",
"x2"]});return e});g(a,"Series/XRange/XRangeComposition.js",[a["Core/Axis/Axis.js"],a["Core/Utilities.js"]],function(a,e){var h=e.addEvent,b=e.pick;h(a,"afterGetSeriesExtremes",function(){var a=this.series,c;if(this.isXAxis){var d=b(this.dataMax,-Number.MAX_VALUE);a.forEach(function(a){a.x2Data&&a.x2Data.forEach(function(a){a>d&&(d=a,c=!0)})});c&&(this.dataMax=d)}})});g(a,"Series/XRange/XRangeSeries.js",[a["Core/Globals.js"],a["Core/Color/Color.js"],a["Core/Series/SeriesRegistry.js"],a["Core/Utilities.js"],
a["Series/XRange/XRangePoint.js"]],function(a,e,h,b,g){var c=this&&this.__extends||function(){var a=function(c,f){a=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(f,a){f.__proto__=a}||function(f,a){for(var n in a)a.hasOwnProperty(n)&&(f[n]=a[n])};return a(c,f)};return function(c,f){function n(){this.constructor=c}a(c,f);c.prototype=null===f?Object.create(f):(n.prototype=f.prototype,new n)}}(),d=e.parse,z=h.series,p=h.seriesTypes.column,A=p.prototype,v=b.clamp,D=b.correctFloat,E=b.defined;
e=b.extend;var B=b.find,r=b.isNumber,w=b.isObject,t=b.merge,x=b.pick;b=function(a){function b(){var f=null!==a&&a.apply(this,arguments)||this;f.data=void 0;f.options=void 0;f.points=void 0;return f}c(b,a);b.prototype.init=function(){p.prototype.init.apply(this,arguments);this.options.stacking=void 0};b.prototype.getColumnMetrics=function(){function f(){a.series.forEach(function(a){var f=a.xAxis;a.xAxis=a.yAxis;a.yAxis=f})}var a=this.chart;f();var b=A.getColumnMetrics.call(this);f();return b};b.prototype.cropData=
function(a,b,c,d){b=z.prototype.cropData.call(this,this.x2Data,b,c,d);b.xData=a.slice(b.start,b.end);return b};b.prototype.findPointIndex=function(a){var f=this.cropped,b=this.cropStart,c=this.points,C=a.id;if(C)var d=(d=B(c,function(a){return a.id===C}))?d.index:void 0;"undefined"===typeof d&&(d=(d=B(c,function(f){return f.x===a.x&&f.x2===a.x2&&!f.touched}))?d.index:void 0);f&&r(d)&&r(b)&&d>=b&&(d-=b);return d};b.prototype.translatePoint=function(a){var f=this.xAxis,b=this.yAxis,d=this.columnMetrics,
c=this.options,e=c.minPointLength||0,k=(a.shapeArgs&&a.shapeArgs.width||0)/2,l=this.pointXOffset=d.offset,q=a.plotX,h=x(a.x2,a.x+(a.len||0)),g=f.translate(h,0,0,0,1);h=Math.abs(g-q);var m=this.chart.inverted,u=x(c.borderWidth,1)%2/2,p=d.offset,y=Math.round(d.width);e&&(e-=h,0>e&&(e=0),q-=e/2,g+=e/2);q=Math.max(q,-10);g=v(g,-10,f.len+10);E(a.options.pointWidth)&&(p-=(Math.ceil(a.options.pointWidth)-y)/2,y=Math.ceil(a.options.pointWidth));c.pointPlacement&&r(a.plotY)&&b.categories&&(a.plotY=b.translate(a.y,
0,1,0,1,c.pointPlacement));c={x:Math.floor(Math.min(q,g))+u,y:Math.floor(a.plotY+p)+u,width:Math.round(Math.abs(g-q)),height:y,r:this.options.borderRadius};a.shapeArgs=c;m?a.tooltipPos[1]+=l+k:a.tooltipPos[0]-=k+l-c.width/2;k=c.x;l=k+c.width;0>k||l>f.len?(k=v(k,0,f.len),l=v(l,0,f.len),e=l-k,a.dlBox=t(c,{x:k,width:l-k,centerX:e?e/2:null})):a.dlBox=null;k=a.tooltipPos;l=m?1:0;e=m?0:1;d=this.columnMetrics?this.columnMetrics.offset:-d.width/2;k[l]=m?k[l]+c.width/2:k[l]+(f.reversed?-1:0)*c.width;k[e]=
v(k[e]+(m?-1:1)*d,0,b.len-1);if(b=a.partialFill)w(b)&&(b=b.amount),r(b)||(b=0),a.partShapeArgs=t(c,{r:this.options.borderRadius}),q=Math.max(Math.round(h*b+a.plotX-q),0),a.clipRectArgs={x:f.reversed?c.x+h-q:c.x,y:c.y,width:q,height:c.height}};b.prototype.translate=function(){A.translate.apply(this,arguments);this.points.forEach(function(a){this.translatePoint(a)},this)};b.prototype.drawPoint=function(a,b){var c=this.options,f=this.chart.renderer,e=a.graphic,h=a.shapeType,k=a.shapeArgs,l=a.partShapeArgs,
g=a.clipRectArgs,n=a.partialFill,p=c.stacking&&!c.borderRadius,m=a.state,u=c.states[m||"normal"]||{},r="undefined"===typeof m?"attr":b;m=this.pointAttribs(a,m);u=x(this.chart.options.chart.animation,u.animation);if(a.isNull||!1===a.visible)e&&(a.graphic=e.destroy());else{if(e)e.rect[b](k);else a.graphic=e=f.g("point").addClass(a.getClassName()).add(a.group||this.group),e.rect=f[h](t(k)).addClass(a.getClassName()).addClass("highcharts-partfill-original").add(e);l&&(e.partRect?(e.partRect[b](t(l)),
e.partialClipRect[b](t(g))):(e.partialClipRect=f.clipRect(g.x,g.y,g.width,g.height),e.partRect=f[h](l).addClass("highcharts-partfill-overlay").add(e).clip(e.partialClipRect)));this.chart.styledMode||(e.rect[b](m,u).shadow(c.shadow,null,p),l&&(w(n)||(n={}),w(c.partialFill)&&(n=t(c.partialFill,n)),a=n.fill||d(m.fill).brighten(-.3).get()||d(a.color||this.color).brighten(-.3).get(),m.fill=a,e.partRect[r](m,u).shadow(c.shadow,null,p)))}};b.prototype.drawPoints=function(){var a=this,b=a.getAnimationVerb();
a.points.forEach(function(c){a.drawPoint(c,b)})};b.prototype.getAnimationVerb=function(){return this.chart.pointCount<(this.options.animationLimit||250)?"animate":"attr"};b.prototype.isPointInside=function(b){var c=b.shapeArgs,e=b.plotX,d=b.plotY;return c?"undefined"!==typeof e&&"undefined"!==typeof d&&0<=d&&d<=this.yAxis.len&&0<=(c.x||0)+(c.width||0)&&e<=this.xAxis.len:a.prototype.isPointInside.apply(this,arguments)};b.defaultOptions=t(p.defaultOptions,{colorByPoint:!0,dataLabels:{formatter:function(){var a=
this.point.partialFill;w(a)&&(a=a.amount);if(r(a)&&0<a)return D(100*a)+"%"},inside:!0,verticalAlign:"middle"},tooltip:{headerFormat:'<span style="font-size: 10px">{point.x} - {point.x2}</span><br/>',pointFormat:'<span style="color:{point.color}">\u25cf</span> {series.name}: <b>{point.yCategory}</b><br/>'},borderRadius:3,pointRange:0});return b}(p);e(b.prototype,{type:"xrange",parallelArrays:["x","x2","y"],requireSorting:!1,animate:z.prototype.animate,cropShoulder:1,getExtremesFromAll:!0,autoIncrement:a.noop,
buildKDTree:a.noop,pointClass:g});h.registerSeriesType("xrange",b);"";return b});g(a,"masters/modules/xrange.src.js",[],function(){})});
//# sourceMappingURL=xrange.js.map