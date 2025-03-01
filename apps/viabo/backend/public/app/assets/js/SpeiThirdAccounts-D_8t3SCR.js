import{t as T,L as p,_ as m,P as A}from"./index-DkbAsBWZ.js";import{i as t,B as x,I as b,bq as S,r as d,T as i,aM as C,bg as g,x as f,br as _}from"./vendor-5lkxkETF.js";import{u as j}from"./useViaboSpeiBreadCrumbs-DFn8fp3c.js";import{u as y}from"./useFindSpeiThirdAccountsList-B8tgoWra.js";import{M as w}from"./MaterialDataTable-Dl1JQ_sM.js";import{u as E}from"./useMaterialTable-8QQmzXWd.js";import{C as P,H as D}from"./HeaderPage-Bqn_U64p.js";const z={account:null,openNewAccount:!1,openDeleteAccount:!1},O=(e,s)=>({...z,setSpeiThirdAccount:o=>{e(r=>({account:o}))},setOpenNewSpeiThirdAccount:o=>{e(r=>({openNewAccount:o}),!1,"SET_OPEN_SPEI_NEW_THIRD_ACCOUNT")},setOpenDeleteSpeiThirdAccount:o=>{e(r=>({openDeleteAccount:o}),!1,"SET_OPEN_SPEI_DELETE_THIRD_ACCOUNT")}}),h=T(O);function v(e){const{row:s,closeMenu:o}=e,{original:r}=s,{status:a}=r,{setOpenDeleteSpeiThirdAccount:c,setSpeiThirdAccount:u}=h();return t.jsx(x,{sx:{display:"flex",flex:1,justifyContent:"flex-start",alignItems:"center",flexWrap:"nowrap",gap:"8px"},children:a&&t.jsx(b,{size:"small",color:"primary",title:"Borrar",onClick:l=>{l.stopPropagation(),u(r),c(!0)},children:t.jsx(S,{color:"error",size:"small",titleAccess:"Borrar"})})})}const B=()=>d.useMemo(()=>[{id:"name",accessorKey:"name",header:"Beneficiario",enableHiding:!1,size:150,Cell:({cell:e,column:s,row:o,renderedCellValue:r})=>t.jsx(i,{fontWeight:"bold",variant:"subtitle2",children:r})},{id:"clabe",accessorKey:"clabe",header:"CLABE",Cell:({cell:e,column:s,row:o,renderedCellValue:r})=>t.jsx(i,{variant:"subtitle2",children:r})},{id:"bank",header:"Banco",accessorFn:e=>{var s;return((s=e==null?void 0:e.bank)==null?void 0:s.name)||null},Cell:({cell:e,column:s,row:o,renderedCellValue:r})=>{const{original:a}=o;return t.jsx(i,{variant:"subtitle2",children:a==null?void 0:a.bank.name})}},{id:"email",accessorKey:"email",header:"Correo",minSize:100,Cell:({cell:e,column:s,row:o,renderedCellValue:r})=>t.jsx(i,{variant:"subtitle2",children:r})},{id:"phone",accessorKey:"phone",header:"Teléfono",Cell:({cell:e,column:s,row:o,renderedCellValue:r})=>t.jsx(i,{variant:"subtitle2",children:r})}],[]),k=()=>{const{data:e,isLoading:s,isError:o,error:r,isFetching:a}=y(),{setOpenNewSpeiThirdAccount:c}=h(),u=B(),l=E(o,r,{columns:u,data:e||[],enableColumnPinning:!0,enableColumnFilterModes:!0,enableStickyHeader:!0,enableRowVirtualization:!0,enableFacetedValues:!0,enableRowActions:!0,enableRowSelection:!0,enableDensityToggle:!1,positionActionsColumn:"last",selectAllMode:"all",initialState:{density:"compact",sorting:[{id:"name",desc:!1}]},state:{isLoading:s,showAlertBanner:o,showProgressBars:a},displayColumnDefOptions:{"mrt-row-select":{maxSize:10},"mrt-row-actions":{header:"Acciones",maxSize:80}},muiTableContainerProps:{sx:{maxHeight:{md:"350px",lg:"450px",xl:"700px"}}},enableColumnResizing:!0,layoutMode:"grid",renderTopToolbarCustomActions:()=>t.jsx(x,{}),renderRowActions:n=>v(n)});return t.jsxs(C,{variant:"outlined",sx:n=>l.getState().isFullScreen?{}:{boxShadow:n.customShadows.z24,backgroundColor:n.palette.mode==="light"?"inherit":n.palette.grey[50012],backdropFilter:"blur(10px)",WebkitBackdropFilter:"blur(10px)"},children:[t.jsx(g,{sx:n=>({pb:2}),title:"Lista de Cuentas",subheader:`Tienes ${(e==null?void 0:e.length)||0} cuentas dadas de alta`,action:t.jsx(f,{title:"Nueva Cuenta",children:t.jsx(b,{color:"primary",size:"large",onClick:()=>c(!0),children:t.jsx(_,{})})})}),t.jsx(w,{table:l})]})},N=p(d.lazy(()=>m(()=>import("./NewSpeiThirdAccountDrawer-BL9Jm8OX.js"),__vite__mapDeps([0,1,2,3,4,5,6,7,8,9,10,11,12,13])))),L=p(d.lazy(()=>m(()=>import("./AlertConfirmationDeleteAccount-CQ3EElFA.js"),__vite__mapDeps([14,2,1,3,5,4,7,8,9,10,11,12,13])))),M=()=>{const{thirdAccounts:e}=j();return t.jsx(A,{title:"Cuentas de Terceros - Viabo Spei",children:t.jsxs(P,{sx:{pb:3},children:[t.jsx(D,{name:"Cuentas de Terceros ",links:e}),t.jsx(k,{}),t.jsx(N,{}),t.jsx(L,{})]})})},U=Object.freeze(Object.defineProperty({__proto__:null,SpeiThirdAccounts:M},Symbol.toStringTag,{value:"Module"}));export{U as S,h as u};
function __vite__mapDeps(indexes) {
  if (!__vite__mapDeps.viteFileDeps) {
    __vite__mapDeps.viteFileDeps = ["assets/js/NewSpeiThirdAccountDrawer-BL9Jm8OX.js","assets/js/index-DkbAsBWZ.js","assets/js/vendor-5lkxkETF.js","assets/css/build-Bl0dWaDY.css","assets/js/useFindSpeiThirdAccountsList-B8tgoWra.js","assets/js/matchTypes-mENztEWg.js","assets/js/RightPanel-DRwW1nHJ.js","assets/js/useViaboSpeiBreadCrumbs-DFn8fp3c.js","assets/js/viabo-spei-paths-CvU5WLsk.js","assets/js/MaterialDataTable-Dl1JQ_sM.js","assets/js/useMaterialTable-8QQmzXWd.js","assets/js/HeaderPage-Bqn_U64p.js","assets/js/fade-CViozI82.js","assets/js/transition-anLY3gj9.js","assets/js/AlertConfirmationDeleteAccount-CQ3EElFA.js"]
  }
  return indexes.map((i) => __vite__mapDeps.viteFileDeps[i])
}
//# sourceMappingURL=SpeiThirdAccounts-D_8t3SCR.js.map
