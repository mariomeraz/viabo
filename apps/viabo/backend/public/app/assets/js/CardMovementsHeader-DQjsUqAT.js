import{aX as be,aY as ke,i as u,bQ as a,B as N,c0 as W,r as k,c1 as C,c2 as Re,bD as Se,c3 as ue,c4 as me,c5 as X,c6 as z,c7 as $,c8 as K,c9 as q,b2 as G,b3 as J,ca as te,cb as ae,cc as Ce,aj as pe,bm as g,y as F,T as Y,aH as T,cd as Oe,ce as H,bE as ne,cf as we,cg as U,ch as je,aR as Te,aP as Ie,J as Pe,ci as O,I as A,cj as Ne,b4 as re,b5 as se,ck as _e,M as oe,cl as He,cm as Fe,cn as We,co as Ye,P,aq as _,S as L,cp as Ae,bB as Be,K as le,aG as Ve,cq as qe,cr as Le,cs as ze,ct as $e}from"./vendor-5lkxkETF.js";import{g as Ke}from"./formatTime-jCgU2sMR.js";import{k as Ge}from"./index-DkbAsBWZ.js";var Z={},Je=ke;Object.defineProperty(Z,"__esModule",{value:!0});var he=Z.default=void 0,Qe=Je(be()),Xe=u;he=Z.default=(0,Qe.default)((0,Xe.jsx)("path",{d:"M16.01 11H4v2h12.01v3L20 12l-3.99-4z"}),"ArrowRightAlt");const Ue=(e,t)=>Array.from({length:Math.ceil(e.length/t)},(n,r)=>e.slice(r*t,r*t+t)),Ze=(e,t)=>{const n=$(G(e),{locale:t}),r=K(J(e),{locale:t}),s=[];for(let o=n;H(o,r);)s.push(o),o=z(o,1);return s},et=({startDate:e},t)=>e&&O(t,e),tt=({endDate:e},t)=>e&&O(t,e),at=({startDate:e,endDate:t},n)=>e&&t&&(U(n,{start:e,end:t})||O(n,e)||O(n,t)),nt=({startDate:e,endDate:t})=>e&&t?O(e,t):!1,ie=(e,t)=>{if(e){const n=e instanceof Date?e:Re(e);if(Se(n))return n}return t},rt=(e,t,n)=>{const{startDate:r,endDate:s}=e;if(r&&s){const o=ue([r,t]),d=me([s,n]);return[o,X(o,d)?C(o,1):d]}return[r,s]},st=(e,t)=>[{label:"Today",startDate:e,endDate:e},{label:"Yesterday",startDate:z(e,-1),endDate:z(e,-1)},{label:"This Week",startDate:$(e,{locale:t}),endDate:K(e,{locale:t})},{label:"Last Week",startDate:$(q(e,-1),{locale:t}),endDate:K(q(e,-1),{locale:t})},{label:"Last 7 Days",startDate:q(e,-1),endDate:e},{label:"This Month",startDate:G(e),endDate:J(e)},{label:"Last Month",startDate:G(C(e,-1)),endDate:J(C(e,-1))},{label:"This Year",startDate:te(e),endDate:ae(e)},{label:"Last Year",startDate:te(W(e,-1)),endDate:ae(W(e,-1))}],ot=(e,t)=>{const n=Math.floor(t/2);return Array(t).fill(0).map((r,s)=>e.getFullYear()-n+s)},lt=({date:e,setDate:t,nextDisabled:n,prevDisabled:r,onClickNext:s,onClickPrevious:o,locale:d})=>{const f=typeof d<"u"?[...Array(12).keys()].map(l=>{var x;return(x=d.localize)===null||x===void 0?void 0:x.month(l,{width:"abbreviated",context:"standalone"})}):["Jan","Feb","Mar","Apr","May","June","July","Aug","Sept","Oct","Nov","Dec"],M=l=>{t(We(e,parseInt(l.target.value,10)))},i=l=>{t(Ye(e,parseInt(l.target.value,10)))};return a.createElement(g,{container:!0,justifyContent:"space-between",alignItems:"center"},a.createElement(g,{item:!0,sx:{padding:"5px"}},a.createElement(A,{sx:{padding:"10px","&:hover":{background:"none"}},disabled:r,onClick:o},a.createElement(Ne,{color:r?"disabled":"action"}))),a.createElement(g,{item:!0},a.createElement(re,{variant:"standard"},a.createElement(se,{value:_e(e),onChange:M,MenuProps:{disablePortal:!0}},f.map((l,x)=>a.createElement(oe,{key:l,value:x},l))))),a.createElement(g,{item:!0},a.createElement(re,{variant:"standard"},a.createElement(se,{value:He(e),onChange:i,MenuProps:{disablePortal:!0}},ot(e,30).map(l=>a.createElement(oe,{key:l,value:l},l))))),a.createElement(g,{item:!0,sx:{padding:"5px"}},a.createElement(A,{sx:{padding:"10px","&:hover":{background:"none"}},disabled:n,onClick:s},a.createElement(Fe,{color:n?"disabled":"action"}))))},it=({startOfRange:e,endOfRange:t,disabled:n,highlighted:r,outlined:s,filled:o,onClick:d,onHover:f,value:M})=>a.createElement(N,{sx:{display:"flex",borderRadius:e?"50% 0 0 50%":t?"0 50% 50% 0":void 0,backgroundColor:i=>!n&&r?i.palette.primary.light:void 0}},a.createElement(A,{sx:Object.assign({height:"36px",width:"36px",padding:0,border:i=>!n&&s?`1px solid ${i.palette.primary.dark}`:void 0},!n&&o?{"&:hover":{backgroundColor:i=>i.palette.primary.dark},backgroundColor:i=>i.palette.primary.dark}:{}),disabled:n,onClick:d,onMouseOver:f},a.createElement(Y,{sx:{lineHeight:1.6,color:i=>n?i.palette.text.secondary:o?i.palette.primary.contrastText:i.palette.text.primary},variant:"body2"},M)));var B;(function(e){e[e.Previous=-1]="Previous",e[e.Next=1]="Next"})(B||(B={}));const ce=e=>{var t;const{helpers:n,handlers:r,value:s,dateRange:o,marker:d,setValue:f,minDate:M,maxDate:i,locale:l}=e,x=((t=l==null?void 0:l.options)===null||t===void 0?void 0:t.weekStartsOn)||0,E=typeof l<"u"?[...Array(7).keys()].map(y=>{var p;return(p=l.localize)===null||p===void 0?void 0:p.day((y+x)%7,{width:"short",context:"standalone"})}):["Su","Mo","Tu","We","Th","Fr","Sa"],[m,R]=e.navState;return a.createElement(pe,{square:!0,elevation:0,sx:{width:290}},a.createElement(g,{container:!0},a.createElement(lt,{date:s,setDate:f,nextDisabled:!R,prevDisabled:!m,onClickPrevious:()=>r.onMonthNavigate(d,B.Previous),onClickNext:()=>r.onMonthNavigate(d,B.Next),locale:l}),a.createElement(g,{item:!0,container:!0,direction:"row",justifyContent:"space-between",sx:{marginTop:"10px",paddingLeft:"30px",paddingRight:"30px"}},E.map((y,p)=>a.createElement(Y,{color:"textSecondary",key:p,variant:"caption"},y))),a.createElement(g,{item:!0,container:!0,direction:"column",justifyContent:"space-between",sx:{paddingLeft:"15px",paddingRight:"15px",marginTop:"15px",marginBottom:"20px"}},Ue(Ze(s,l),7).map((y,p)=>a.createElement(g,{key:p,container:!0,direction:"row",justifyContent:"center"},y.map(h=>{const v=et(o,h),w=tt(o,h),S=nt(o),I=at(o,h)||n.inHoverRange(h);return a.createElement(it,{key:T(h,"dd-MM-yyyy"),filled:v||w,outlined:we(h),highlighted:I&&!S,disabled:!X(s,h)||!U(h,{start:M,end:i}),startOfRange:v&&!S,endOfRange:w&&!S,onClick:()=>r.onDayClick(h),onHover:()=>r.onDayHover(h),value:je(h)})}))))))},de=(e,t)=>{const{startDate:n,endDate:r}=e,{startDate:s,endDate:o}=t;return n&&s&&r&&o?O(n,s)&&O(r,o):!1},ct=({ranges:e,setRange:t,selectedRange:n,verticalOrientation:r})=>a.createElement(Te,{sx:{flexDirection:r?"row":"column",display:"flex",overflowY:"scroll"}},e.map((s,o)=>a.createElement(Ie,{button:!0,key:o,onClick:()=>t(s),sx:[de(s,n)&&{backgroundColor:d=>d.palette.primary.dark,color:"primary.contrastText","&:hover":{color:"inherit"}}]},a.createElement(Pe,{primaryTypographyProps:{variant:"body2",sx:{fontWeight:de(s,n)?"bold":"normal"}}},s.label)))),Q={FIRST_MONTH:Symbol("firstMonth"),SECOND_MONTH:Symbol("secondMonth")},dt={writingMode:"vertical-lr",transform:"rotate(180deg)"},ut=e=>{const{ranges:t,dateRange:n,minDate:r,maxDate:s,firstMonth:o,setFirstMonth:d,secondMonth:f,setSecondMonth:M,setDateRange:i,helpers:l,handlers:x,locale:E,verticalOrientation:m}=e,{startDate:R,endDate:y}=n,p=Ce(f,o)>=2,h={dateRange:n,minDate:r,maxDate:s,helpers:l,handlers:x},v=Object.assign({flex:1,textAlign:"center"},m?dt:{});return a.createElement(pe,{elevation:5,square:!0},a.createElement(g,{container:!0,direction:m?"column":"row",wrap:"nowrap"},a.createElement(g,null,a.createElement(ct,{selectedRange:n,ranges:t,setRange:i,verticalOrientation:m})),a.createElement(F,{orientation:m?"horizontal":"vertical",flexItem:!0}),a.createElement(g,{display:"flex",flexDirection:m?"row":"column"},a.createElement(g,{container:!0,direction:m?"column":"row",sx:m?{}:{padding:"20px 70px"},alignItems:"center"},a.createElement(g,{item:!0,sx:v},a.createElement(Y,{variant:"subtitle1"},R?T(R,"dd MMMM yyyy",{locale:E}):"Start Date")),a.createElement(g,{item:!0,sx:{flex:m?.5:1,display:"flex",justifyContent:"center",alignItems:"center"}},m?a.createElement(Oe,{color:"action"}):a.createElement(he,{color:"action"})),a.createElement(g,{item:!0,sx:v},a.createElement(Y,{variant:"subtitle1"},y?T(y,"dd MMMM yyyy",{locale:E}):"End Date"))),a.createElement(F,null),a.createElement(g,{container:!0,direction:m?"column":"row",justifyContent:"center",wrap:"nowrap"},a.createElement(ce,Object.assign({},h,{value:o,setValue:d,navState:[!0,p],marker:Q.FIRST_MONTH,locale:E})),a.createElement(F,{orientation:m?"horizontal":"vertical",flexItem:!0}),a.createElement(ce,Object.assign({},h,{value:f,setValue:M,navState:[p,!0],marker:Q.SECOND_MONTH,locale:E}))))))},mt=e=>{const t=new Date,{open:n,onChange:r,initialDateRange:s,minDate:o,maxDate:d,definedRanges:f=st(new Date,e.locale),locale:M,verticalOrientation:i}=e,l=ie(o,W(t,-10)),x=ie(d,W(t,10)),[E,m]=rt(s||{},l,x),[R,y]=k.useState(Object.assign({},s)),[p,h]=k.useState(),[v,w]=k.useState(E||t),[S,I]=k.useState(m||C(v,1)),{startDate:j,endDate:V}=R,ge=c=>{H(c,S)&&w(c)},fe=c=>{ne(c,v)&&I(c)},xe=c=>{let{startDate:D,endDate:b}=c;if(D&&b)c.startDate=D=ue([D,l]),c.endDate=b=me([b,x]),y(c),r(c),w(D),I(X(D,b)?C(D,1):b);else{const ee={};y(ee),r(ee),w(t),I(C(v,1))}},ye=c=>{if(j&&!V&&!H(c,j)){const D={startDate:j,endDate:c};r(D),y(D)}else y({startDate:c,endDate:void 0});h(c)},ve=(c,D)=>{if(c===Q.FIRST_MONTH){const b=C(v,D);H(b,S)&&w(b)}else{const b=C(S,D);H(v,b)&&I(b)}},De=c=>{j&&!V&&(!p||!O(c,p))&&h(c)},Me={inHoverRange:c=>j&&!V&&p&&ne(p,j)&&U(c,{start:j,end:p})},Ee={onDayClick:ye,onDayHover:De,onMonthNavigate:ve};return n?k.createElement(ut,{dateRange:R,minDate:l,maxDate:x,ranges:f,firstMonth:v,secondMonth:S,setFirstMonth:ge,setSecondMonth:fe,setDateRange:xe,helpers:Me,handlers:Ee,locale:M,verticalOrientation:!!i}):null},pt=e=>{const{closeOnClickOutside:t,wrapperClassName:n,toggle:r,open:s}=e,o=()=>{t!==!1&&r()},d=f=>(f==null?void 0:f.key)==="Escape"&&o();return a.createElement(N,{sx:{position:"relative"}},s&&a.createElement(N,{sx:{position:"fixed",height:"100vh",width:"100vw",bottom:0,zIndex:0,right:0,left:0,top:0},onKeyPress:d,onClick:o}),a.createElement(N,{sx:{position:"relative",zIndex:1},className:n},a.createElement(mt,Object.assign({},e))))},ht=e=>a.createElement(pt,Object.assign({},e)),gt=({startDate:e,endDate:t,onChangeDateRange:n,loading:r,onOpenBalance:s,hideBalance:o=!1})=>{const d=k.useMemo(()=>Ke(),[]),f=k.useRef(null),M=Ge("down","md"),[i,l]=k.useState(!1),[x,E]=k.useState(i),m=()=>{l(!i),i||E(!0)},R=k.useMemo(()=>e?T(e,"dd MMMM yyyy",{locale:_}):T(new Date,"dd MMMM yyyy",{locale:_}),[e]),y=k.useMemo(()=>t?T(t,"dd MMMM yyyy",{locale:_}):T(new Date,"dd MMMM yyyy",{locale:_}),[t]),p=`${R} - ${y}`;return u.jsxs(u.Fragment,{children:[u.jsxs(L,{py:2,px:1,flexDirection:{lg:"row"},justifyContent:"space-between",alignItems:"center",gap:1,children:[u.jsxs(L,{flex:1,width:1,direction:"row",spacing:.5,children:[u.jsx(A,{disabled:!!r,onClick:m,size:"small",children:u.jsx(Ae,{})}),u.jsx(L,{flex:1,children:u.jsx(Be,{placeholder:"Fecha inicial - Fecha final",value:p,fullWidth:!0,type:"text",variant:"outlined",size:"small",disabled:!!r,onClick:m,InputProps:{readOnly:!0}})})]}),u.jsx(N,{display:"flex",flexGrow:1}),u.jsx(N,{display:"flex",flexGrow:1,justifyContent:"flex-end",children:!o&&u.jsx(le,{variant:"contained",color:"secondary",disabled:!!r,startIcon:u.jsx(Ve,{}),sx:{color:"text.primary",fontWeight:"bolder"},onClick:s,children:"Ver Balance del Periodo"})}),u.jsxs(qe,{open:x,ref:f,scroll:"paper","aria-labelledby":"scroll-dialog-title","aria-describedby":"scroll-dialog-description",maxWidth:"md",children:[u.jsx(Le,{variant:"subtitle1",fontWeight:"bolder",sx:{mb:2},id:"scroll-dialog-title",children:"Confirma las fechas seleccionadas"}),u.jsx(ze,{id:"scroll-dialog-description",dividers:!0,children:u.jsx(ht,{open:i,onChange:n,verticalOrientation:M,toggle:m,locale:_,definedRanges:d,closeOnClickOutside:!1,wrapperClassName:"simple-date-range"})}),u.jsx($e,{children:u.jsx(le,{variant:"contained",color:"primary",onClick:()=>{E(!1),setTimeout(()=>{l(!1)},200)},children:"Hecho"})})]})]}),u.jsx(F,{sx:{borderStyle:"dashed"}})]})};gt.propTypes={endDate:P.any.isRequired,loading:P.any,onChangeDateRange:P.func.isRequired,onOpenBalance:P.func,startDate:P.any.isRequired,hideBalance:P.bool};export{gt as C};
//# sourceMappingURL=CardMovementsHeader-DQjsUqAT.js.map
