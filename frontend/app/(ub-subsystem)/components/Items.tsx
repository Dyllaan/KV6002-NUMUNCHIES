"use client"
/* Items
Component to display all of the items that are available within the next 24 hours. 
@author Cameron Bramley - w21020682
@generated This function was made with the help of chatGPT
*/
import { useState, useEffect } from 'react';
import { atom, useAtom } from "jotai";
import { useRouter } from 'next/navigation';
import { ClockIcon } from '@radix-ui/react-icons';
import Categories from '@/app/(food-subsystem)/components/Category';
import SearchBar from '@/app/(food-subsystem)/components/SearchBar';
import { StarIcon } from '@radix-ui/react-icons';

/*
* @generated - chatGPT was used to help solve errors regarding interface. It suggested adding '| undefined' at the end.
*/
interface Item {
  id?: number
  business_id?: number | undefined;
  item_name?: string | undefined;
  item_price?: number | undefined;
  item_expiry?: string | undefined;
  collect_time?: string | undefined;
  collect_date?: string | undefined;
  average_rating?: string | undefined;
  business_name?: string | undefined;
  address_line1?: string | undefined;
  address_postcode?: string | undefined;
  address_city?: string | undefined;
  business_description?: string | undefined;
  weight: number | undefined;
  calories: number | undefined;
  protein: number | undefined;
  carbs: number | undefined;
  fat: number | undefined;
  salt: number | undefined;
  quantity: number | undefined;
}

function Items() {
  const router = useRouter();
  const [items, setItems] = useState<{ data: Item[] }>({
    data: []
  });
  //setting global variable for use on the view item page...
  const [selectedItem, setSelectedItem] = useAtom(selectedItemAtom);

  //used to check if the collection_time's date is today or tomorrow. 
  const today = new Date();
  const todaysDate = String(today.getDate());

  //fetch items
  const fetchData = async () => {
    const res = await fetch("https://backend.nu-munchies.xyz/getitems")
    return res.json()
  }

  useEffect(() => {
    if (items.data.length > 0) return;
    fetchData().then(res => {
      setItems(res);
    });
  }, [items.data.length]);

  //redirect user to the view item page...
  const handleClick = (item: Item) => {
    setSelectedItem(item);
    router.replace("/viewitem");
  }

  return (
    <>
      <SearchBar />
      <Categories />
      {items.data?.map((value, key) => (
        <div key={key} className="border border-grey-200 rounded-md my-4" onClick={() => handleClick(value)}>
          <div className="pb-3 ">
            <p className="font-bold flex text-red-500 text-lg">{value.item_name}</p>
            <div className="flex items-center">
              <p>{value.business_name}</p>
              <StarIcon color='red' className="ml-1" radius='full' />
              <p>{value.average_rating}</p>
            </div>
            <p className="text-sm text-gray-500 flex">{value.address_city} <span className="text-black"> | </span> {value.address_postcode}</p>
          </div>

          <div className="flex relative text-sm items-center">
            <ClockIcon className="w-3 h-3" />
            {value.collect_date !== todaysDate ? (
              <>
                <p className="ml-1">{value.collect_time} (tomorrow)</p>
              </>
            ) : (
              <>
                <p className="ml-1">{value.collect_time}</p>
              </>
            )}
            <p className="absolute bottom-0 right-0">£{value.item_price}</p>
          </div>
        </div>
      ))}
    </>
  );
}
//export atom variable...
export const selectedItemAtom = atom<Item>({ id: undefined, item_name: undefined, item_price: undefined, item_expiry: undefined, average_rating: undefined, collect_time: undefined, collect_date: undefined, business_name: undefined, address_line1: undefined, address_postcode: undefined, address_city: undefined, business_description: undefined, weight: undefined, calories: undefined, protein: undefined, carbs: undefined, fat: undefined, salt: undefined, quantity: undefined });

export default Items;
