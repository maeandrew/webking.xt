(function(){var g=window.sfx,b=window.cfx;b.animationVersion="7.3.5529.24241";b.AnimationDelay={Auto:0,None:4096,PerPoint:1,PerSeries:2,PerPointInverse:17,PerSeriesInverse:18,PerPointRandom:33,PerSeriesRandom:34,PerPointSeries:3,PerPointSeriesRandom:35};b.AnimationDirection={Auto:0,Upward:1,Downward:2,FromCenter:3};b.AnimationTiming={Auto:0,Linear:1,EaseIn:2,EaseOut:3,EaseInEaseOut:4,EaseOutBounce:5};b.BarAnimation={Value:0,Drop:1};b.BubbleAnimation={Position:0,Size:1,PositionAndSize:2};b.LineAnimation=
{DrawX:0,YData:1,YProgress:2};b.PieAnimation={Radial:1,Angle:2,RadialAndAngle:3,AngleFromTop:258,RadialAngleFromTop:259};var j=function r(){r._ic();this.d=this.e=0;this.a=!1;this.c=0};j.prototype={_0co:function(){this.b=1.2;return this},getDelay:function(){return this.e},setDelay:function(b){this.e=b},getDirection:function(){return this.d},setDirection:function(b){this.d=b},getDuration:function(){return this.b},setDuration:function(b){this.b=b},getEnabled:function(){return this.a},setEnabled:function(b){this.a=
b},getTiming:function(){return this.c},setTiming:function(b){this.c=b}};j._dt("A",g.SA,0);var m=function s(){s._ic();this.n=!1;this.a=this.m=this.e=this.c=null;this.f=this.l=!1;this.d=null;this.j=this.k=0;this.i=null;this.g=this.h=!1};b.cp=m;m.prototype={_0cp:function(b){this.b=b;return this},r:function(){null==this.c&&(this.c=(new d)._0cr(this,this.m));return this.c},getDataChange:function(){null==this.a&&(this.a=(new j)._0co(),this.a.b=0.4);return this.a},getLoad:function(){null==this.d&&(this.d=
(new j)._0co());return this.d},getShowSpeed:function(){return this.g},setShowSpeed:function(b){this.g=b},o:function(){var b=this.b.m;this.j=b.iaN();this.k=b.iaI();this.i=b.iaP().j(this.j,this.k,!1,!0);this.e=Array(2*this.b.getAxesY().Se());for(var b=0,h=this.b.getAxesY().Sb();!0==h.SK();){var a=h.SM();this.e[b++]=a.v;this.e[b++]=a.C}},q:function(b,h){if(this.n)return!0;this.f=b;this.h&&(this.h=!1,this.f=!0);if(this.f){this.m=this.d;var a=null!=this.d&&this.d.a;!a&&(null!=this.a&&this.a.a&&null==this.i)&&
this.o();return a&&!this.l}if(h){if(null==this.a||!this.a.a)return!1;var f=this.b.m,a=!1;if(this.j!=f.iaN()||this.k!=f.iaI())a=!0;else for(var f=0,c=this.b.getAxesY().Sb();!0==c.SK();){var e=c.SM();if(this.e[f++]!=e.v){a=!0;break}if(this.e[f++]!=e.C){a=!0;break}}if(a)return this.o(),!1;this.m=this.a;return!0}return!1},p:function(b,h){null!=this.c&&!this.c.al(b,h)&&(null!=this.a&&this.a.a&&this.o(),this.l=!0,this.c=null,this.n=!1)},reset:function(){this.l=!1;this.c=null;this.h=!0;this.b.e(32)}};m._dt("A",
g.SA,0);var l=function h(){h._ic();this.d=null;this.e=this.a=this.b=0;this.i=!1;this.o=this.k=null;this.f=this.g=0;this.n=null;this.c=this.h=0};b.cq=l;l.prototype={_0cq:function(b){this.m=b;return this},getCompactFormula:function(){return this.d.getCompactFormula()},setCompactFormula:function(b){this.d.setCompactFormula(b)},getHasData:function(){return!0},getShared:function(){return this.d.getShared()},setShared:function(b){this.d.setShared(b)},getItem1:function(b){return this.d.getItem1(b)},setItem1:function(b,
a){this.d.setItem1(b,a)},getItem:function(h,a){var f=0;if(null!=this.d){if(f=this.d.getItem(h,a),0!=(this.e&32))return f+=this.k.getItem(h,a)}else f=this.f;if(b.c_.g(f))return f;var c=this;if(0!=this.m.F){if(0==(this.m.F&1<<h))return f;null!=this.o&&0!=h&&(c=this.o[h-1])}var e=this.m.I(h,a,this.c);return c.p(h,a,f,e)},setItem:function(b,a,f){this.d.setItem(b,a,f)},clear:function(){this.d.clear()},q:function(b){return this.f!=b.f||this.g!=b.g||this.i!=b.i||this.h!=b.h||this.e!=b.e||this.b!=b.b||this.c!=
b.c||this.a!=b.a?!1:!0},p:function(b,a,f,c){var e=0,i=0,i=null!=this.n?this.n[b][a]:this.f;3==this.a&&(e=(this.g+this.f)/2);b=0;this.i&&(b=0<f?this.g:this.f);if(0>=c){if(this.i)return 2==this.a?b:0;switch(this.a){case 1:return i;case 2:return this.g;case 3:return e}}if(0!=(this.e&2))return b=0,2==this.a?(b=this.g-c*this.h,b<f&&(b=f)):1==this.a?(b=i+c*this.h,b>f&&(b=f)):(i=g.a.o(this.g-e,e-this.f),f<e?(b=e-c*i,b<f&&(b=f)):(b=e+c*i,b>f&&(b=f))),b;if(this.i)return 2==this.a?b-c*(b-f):c*f;switch(this.a){case 2:return this.g-
c*(this.g-f);case 3:return e+c*(f-e)}return i+c*(f-i)},l:function(b){this.f=b.q;this.g=b.t;this.i=0<this.g&&0>this.f;this.h=this.g-this.f}};l._dt("IA",g.SA,0);var d=function a(){a._ic();this.f=!1;this.x=this.d=this.t=this.i=this.e=this.l=0;this.p=null;this.h=0;this.r=!1;this.H=0;this.j=null;this.W=this.X=this.k=0;this.G=null;this.V=this.C=0;this.w=null;this.b=this.B=0;this.a=null;this.F=0;this.U=null;this.v=!1;this.E=null;this.n=this.g=0;this.m=null;this.A=!1;this.q=this.T=null;this.z=0;this.R=null;
this.y=0};d.prototype={_0cr:function(a,b){this.c=new g.c;this.w=a;this.U=b;this.i=b.b;this.e=b.e;this.n=b.c;this.x=1;this.V=0.35;return this},aj:function(a){this.v&&(a.h.x=this.W,a.a.x=this.X);1<=this.b&&this.O(a.c)},o:function(a,b){switch(b){case 2:return a*a;case 3:return-a*(a-2);case 4:a/=0.5;if(1>a)return 0.5*a*a;a--;return-0.5*(a*(a-2)-1);case 5:return this.ao(a)}return a},ap:function(a){if(1<=this.b)return null!=this.p?(a.V=!1,this.p=g.V.C(a.c,b.ic6),this.p.ic8(1),this.O(a.c),!1):!0;var f=a.h,
c=null==this.E,e=0;if(c){this.w.n=!0;this.E=g.ah.L();this.B=g.a.d(a.p-a.o)+1;var i=!1,e=!this.w.f;if(0==(a.bZ&524288)||e)this.a=(new l)._0cq(this),this.a.a=this.U.d,0!=(a.m&64)&&(i=!0);else{var d=a.bH.getSeries();this.j=Array(d.Se());for(var n=null,o=!0,p=null,k=0;k<d.Se();){var q=d.getItem(k).W;null==q&&(null==p&&(p=a.bH.getGalleryAttributes(),p=g.V.C(p,b.icU)),q=p);var j=d.getItem(k).getGallery(),m=(new l)._0cq(this);a.ah&&m.l(f);this.a=this.j[k]=m;this.P(a,q,j,f);null!=n&&o&&(o=this.a.q(n));0!=
(q.icX(j)&64)&&(i=!0);k+=q.icW(j);n=this.a}o&&(this.j=null)}this.R=a.aj;this.T=a.P;if(a.ah){if(this.C=0,d=g.a.p(a.ar,a.as),n=g.a.p(a.z,a.F),o=g.a.d(a.as-a.ar),k=g.a.d(a.F-a.z),this.c._i2(d,n,o,k),f.V(a.a)&&(this.c.w=k,this.c.h=o,this.c.x=n,this.c.y=d),i)i=a.b.j,a.i.valueToPixel(1)-i<this.c.x&&this.c.m(i,0),0==(this.d&1)&&this.c.m(0,i+2)}else this.c._cf(a.k);null==this.j&&this.a.l(f);e&&(this.h|=4,this.a.n=this.w.i);null==this.j&&(this.P(a,a.b.i,a.b.p,f),this.Q(),this.af(a));a.ah?(this.z=g.a.p(a.ar,
a.as),this.y=g.a.p(a.z,a.F)):(this.z=a.k.x,this.y=a.k.y);if(0!=(this.d&64))return this.b=1,!0;e=0}else this.A&&this.N(),e=this.o(this.b,this.n);1>e&&(a.V=!0,a.aK=this.f);this.H++;null==this.j&&!this.f&&0!=(this.d&1)&&(0!=(this.e&2)?c&&this.ag(a):this.r&&!c&&this.D(a,e));return 0!=(a.v&128)?(a.V=!1,this.p=g.V.C(a.c,b.ic6),this.p.ic8(this.Y()),0==this.b):!0},ai:function(a){if(1<=this.b)if(0!=(this.h&1))this.h&=-2;else return!1;var b=!1;null!=this.j?(b=!0,a.ah||this.ae(a)):b=this.ah(a);return b},ah:function(a){var b=
!1;if(this.f){if(a.aj=this.a,null!=this.a.k&&(a.aF=this.a.k),null!=this.q)a.P=this.q}else if(0!=(this.d&1))if(0!=(this.e&2))b=!0;else{if(0==this.b&&null==this.j||!this.r){var c=this.o(this.b,this.x);this.D(a,c)}}else if(this.v){var c=this.o(this.b,this.n),e=a.h;this.W=e.x;this.X=a.a.x;c*=g.a.d(a.F-a.z);c=g.a.o(c,1);e.aF(c,!1);2==this.a.a?a.a.x=a.a.J+c:3==this.a.a&&(a.a.x=g.i(a.a.x+a.a.J+c,2))}return b},ao:function(a){if(a<d.M)return d.u*a*a;if(a<d.L)return a-=d.ad,d.u*a*a+d.ab;if(a<d.K)return a-=
d.ac,d.u*a*a+d.aa;a-=d.J;return d.u*a*a+d.Z},ag:function(a){a=g.a.d(a.u-a.t)+1;this.l=3==(this.e&3)?a*this.B:0!=(this.e&2)?a:this.B;this.an(this.l);if(0!=(this.e&32)){this.m=Array(this.l);for(a=0;a<this.l;a++)this.m[a]=a;for(var b=new g.U,a=0;a<this.l;a++){var c=b.c(this.l-a),e=this.m[a];this.m[a]=this.m[c];this.m[c]=e}}},af:function(a){this.A=this.v=this.r=!1;a.aK=!1;0!=(a.v&128)?this.A=this.f=!1:(this.f=(4096!=this.e||a.g(256)||0!=(this.d&2))&&0==(this.d&1)&&a.ah,0!=(this.d&8)&&(this.f=!0),0!=(this.d&
16)&&(this.f=!1),0!=(this.h&4)&&(this.f=!0,this.d&=-2),this.v=a.ah&&!this.f,0!=(this.d&1)&&(this.v=!1,4096==this.e&&null==this.j&&0==(a.v&64)&&(this.r=!0)),(this.f||!a.ah)&&4096!=this.e&&this.ag(a),this.f&&(this.a.d=a.aj,0!=(this.d&4)&&a.P.getHasData()&&(this.q=(new l)._0cq(this),this.q.d=a.P,this.q.l(a.i),this.q.a=this.a.a,0==(this.h&2)&&(this.h|=2,this.c.m(5,0)))),a.aK=this.f)},an:function(a){var b=a*this.V,c=0;1.3>b?(b=2.5,this.g=3.5*(this.i/5)):this.g=2*(this.i/5);this.k=0;for(var e=0.5,d=a-1,
j=0;8>j;j++){this.g=g.a.o(this.g,e);c=d*this.k+this.g;if(0.2>g.a.d(c-this.i))break;this.k=this.g/b;if(this.k>=0.8*this.g)e*=1.3;else{c=d*this.k+this.g;if(0.2>g.a.d(c-this.i))break;c>this.i&&(c=(this.i-this.g)/a,0.2>c&&(b*=1.5),this.k=(this.k+c)/2);this.g=this.i-d*this.k}}},ae:function(a){0!=(this.d&1)&&a.c.sic_(null);this.f&&(a.aj=this.R,a.P=this.T);null!=this.j&&(this.a=this.j[a.d],this.Q(),this.af(a),this.ah(a));if(0!=(this.d&1)){var b=this.I(a.d,0,this.n);a.c.sic_(null);this.D(a,b)}},am:function(){0==
this.a.b&&(this.a.b=1);0==this.a.c&&(this.a.c=4);0==this.a.a&&(this.a.a=1)},Y:function(){return this.o(this.b,this.n)},I:function(a,b,c){if(4096==this.e)return this.o(this.b,c);var e=0,e=3==(this.e&3)?a*this.B+b:0!=(this.e&1)?b:a;0!=(this.e&16)&&(e=this.l-e-1);null!=this.m&&(e=this.m[e]);a=e*this.k;if(this.t<=a)return 0;b=a+this.g;if(this.t>=b)return 1;a=(this.t-a)/(b-a);return a=this.o(a,c)},al:function(a,b){if(1<=this.b)return!1;var c=0;this.A||(this.N(),c=this.o(this.b,this.n));var e=this.c._nc();
null!=this.p?1<=this.b?(this.h|=1,e._cf(this.c)):this.p.ic7(c,e):this.r&&1>c&&(e._i2(0,this.c.y,c*this.c.w,this.c.h),a.repaintElem="plotArea",a.repaintClip=e,null==b&&this.H++);1<=this.b&&e._cf(a.SP());a.Sad(e);return!0},Q:function(){this.e=this.a.b;this.n=this.a.c;this.d=this.a.e},D:function(a,b){var c=0,e=b*this.c.w;if(this.r){if(0!=b)return;var d=e-this.C,c=this.c.x+this.C;this.C=e;e=d+1}else c=this.c.x;c=(new g.c)._02c(c,this.c.y,e,this.c.h);c=(new g.aq)._0aq(c);a.c.sic_(c);null!=this.G&&this.G._d();
this.G=c},ak:function(){this.a.b=this.e;this.a.c=this.n;this.a.e=0},P:function(a,b,c,e){this.ak();var d=null;0!=(b.icX(c)&262144)&&a.aF.getHasData()&&(d=(new l)._0cq(this),d.l(e),d.d=a.aF,this.a.k=d);0==(this.h&4)&&b.icV(c,11,this,a);null!=d&&0==d.a&&(d.a=this.a.a);this.am()},O:function(a){if(this.w.g){a.sidb(null);var b=new g.at,c=(new g.o)._0o("Helvetica",8),e=g.D._l(this.H/this.i,"f2",null),d=(new g.ar)._0ar(g.m.i());a.idS(d,this.z,this.y,32,14);d._d();a.idF(e,c,g.aj.G(),this.z,this.y,b);c._d();
b._d()}},N:function(){this.t=this.E.J()/1E3;this.b=this.t/this.i;this.b=g.a.p(this.b,1);1!=this.x&&(this.b=this.o(this.b,this.x),this.t=this.i*this.b)}};d.M=0.363636363636364;d.L=0.727272727272727;d.K=0.909090909090909;d.J=0.954545454545455;d.M=0.7;d.L=0.9;d.K=0.92;d.J=0.96;d.u=2.04081632653061;d.ad=0.8;d.ab=0.979591836734694;d.ac=0.91;d.aa=0.999795918367347;d.Z=0.996734693877551;d._dt("IA",g.SA,0);b.Chart.prototype.getAnimations=function(){null==this.Z&&(this.Z=(new b.cp)._0cp(this));return this.Z};
"undefined"!=typeof b.eR&&(b.eR.prototype.getAnimationStyle=function(){return this.F});"undefined"!=typeof b.eR&&(b.eR.prototype.setAnimationStyle=function(a){this.F=a});"undefined"!=typeof b.VectorBar&&(b.VectorBar.prototype.getAnimationStyle=function(){return this.q});"undefined"!=typeof b.VectorBar&&(b.VectorBar.prototype.setAnimationStyle=function(a){this.q=a});"undefined"!=typeof b.VectorBubble&&(b.VectorBubble.prototype.getAnimationStyle=function(){return this.q});"undefined"!=typeof b.VectorBubble&&
(b.VectorBubble.prototype.setAnimationStyle=function(a){this.q=a});"undefined"!=typeof b.VectorPie&&(b.VectorPie.prototype.getAnimationStyle=function(){return this.t});"undefined"!=typeof b.VectorPie&&(b.VectorPie.prototype.setAnimationStyle=function(a){this.t=a});"undefined"!=typeof b.bE&&(b.bE.prototype.getAnimationStyle=function(){return this.c});"undefined"!=typeof b.bE&&(b.bE.prototype.setAnimationStyle=function(a){this.c=a});"undefined"!=typeof b.bD&&(b.bD.prototype.getAnimationStyle=function(){return this.d});
"undefined"!=typeof b.bD&&(b.bD.prototype.setAnimationStyle=function(a){this.d=a});"undefined"!=typeof b.bC&&(b.bC.prototype.getAnimationStyle=function(){return this.c});"undefined"!=typeof b.bC&&(b.bC.prototype.setAnimationStyle=function(a){this.c=a});"undefined"!=typeof b.bB&&(b.bB.prototype.getAnimationStyle=function(){return this.p});"undefined"!=typeof b.bB&&(b.bB.prototype.setAnimationStyle=function(a){this.p=a});"undefined"!=typeof b.bz&&(b.bz.prototype.getAnimationStyle=function(){return this.b});
"undefined"!=typeof b.bz&&(b.bz.prototype.setAnimationStyle=function(a){this.b=a});"undefined"!=typeof b.bw&&(b.bw.prototype.getAnimationStyle=function(){return this.e});"undefined"!=typeof b.bw&&(b.bw.prototype.setAnimationStyle=function(a){this.e=a})})();
