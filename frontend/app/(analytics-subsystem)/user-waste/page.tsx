'use client'
/*
Items

@author Jake McCarthy (w20043974) 
*/

import requireAuth from "../../(user-subsystem)/components/requireAuth";
import useUserSubsystem from "@/hooks/user-subsystem/use-user-subsystem";
import {Table,TableBody,TableCaption, TableCell,TableFooter,TableHead,TableHeader,TableRow, } from "@/components/ui/table"
import { useState, useEffect } from 'react'

function Page() {
const { user, logout, isOAuth } = useUserSubsystem();
const [orders, setOrders] = useState([]);
const token = localStorage.getItem('token');
const headers = {
    'Authorization': `Bearer ${token}`
};

    const fetchData = () => { 
        fetch("http://localhost:8080/analytics/user-orders", {
            method: 'GET',
            headers: headers
        })
        .then( response => response.json() )
        .then( json => setOrders(json) )
        .then( json => console.log(json) )
        .catch(error => {
          console.error('Error fetching data:', error); 
    });}

    console.log(orders)
 
    useEffect( fetchData, [])
    

      if (!orders || !orders.data) {
        return <div>Loading...</div>;
    }

    return (
      <div>

        <div>
          Total Food Waste Prevented: 
           {orders.data.totalWaste}kg
        </div>
        <div>
          Total Orders Placed:
         {orders.data.totalOrders}
        </div>
      
      <Table>
        <TableCaption>A list of your total orders</TableCaption>
        <TableHeader>
          <TableRow>
            <TableHead className="w-[100px]">Order Number:</TableHead>
            <TableHead>Business Name:</TableHead>
            <TableHead>Item Purchased:</TableHead>
            <TableHead>Waste Prevented:</TableHead>
            <TableHead>Order Date:</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
  {orders.data.orderStats.map((order) => (
    <TableRow key={order.order_number}>
      <TableCell className="font-medium">{order.order_number}</TableCell>
      <TableCell>{order.business_name}</TableCell>
      <TableCell>{order.item_name}</TableCell>
      <TableCell>{order.item_name}</TableCell>
      <TableCell>{order.purchaseDate}</TableCell>
    </TableRow>
          ))}
        </TableBody>
        <TableFooter>
          <TableRow>
            <TableCell colSpan={3}>Total Orders</TableCell>
            <TableCell className="text-right">{orders.data.totalOrders}</TableCell>
          </TableRow>
        </TableFooter>
      </Table>

      </div>
    )
  }

export default requireAuth(Page)