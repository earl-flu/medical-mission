import{P as f,R as m}from"./app-CmUxgkoC.js";const l=f("cart",()=>{let t=m([]);function o(e){const{id:n,name:r,lot_no:i}=e;if(!t.some(a=>a.id===e.id))return t.push({id:n,name:r,lot_no:i,instruction:"",order_quantity:1})}function d(e){const n=t.findIndex(r=>r.id===e);n!==-1&&t.splice(n,1)}function s(e,n){const r=t.find(i=>i.id===e);return r.order_quantity=n}function u(e,n){const r=t.find(i=>i.id===e);return r.instruction=n}function c(){t.splice(0,t.length)}return{orderItems:t,addOrderItem:o,removeOrderedItem:d,orderedItemsReset:c,adjustOrderQuantity:s,updateOrderInstruction:u}});export{l as u};
