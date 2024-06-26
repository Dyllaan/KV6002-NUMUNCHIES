"use client";
import requireType from '../auth/requireType';
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from "@/components/ui/accordion"
import SearchUsers from './SearchUsers';
import SearchBusiness from './SearchBusiness';

function Moderator() {
  return (
    <div className="m-2 justify-center">
      <h1 className="text-center">Moderator</h1>
      <Accordion type="single" collapsible className="w-full">
        <AccordionItem value="item-1">
          <AccordionTrigger>Manage Users</AccordionTrigger>
          <AccordionContent>
          <SearchUsers />
          </AccordionContent>
        </AccordionItem>
        <AccordionItem value="item-2">
          <AccordionTrigger>Manage Businesses</AccordionTrigger>
          <AccordionContent>
          <SearchBusiness />
          </AccordionContent>
        </AccordionItem>
    </Accordion>
    </div>
    );
}

export default requireType(Moderator, 'moderator');
