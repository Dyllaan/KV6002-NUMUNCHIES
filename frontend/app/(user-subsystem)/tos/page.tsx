"use client";
import { Separator } from "@/components/ui/separator"
import {
  Tooltip,
  TooltipContent,
  TooltipProvider,
  TooltipTrigger,
} from "@/components/ui/tooltip"
import { useRouter, useSearchParams } from 'next/navigation';
import RedirectTo from "../components/RedirectTo";
import Link from "next/link";
import { Button } from "@/components/ui/button";
/**
 * The TOS is produced by ChatGPT as a placeholder as I am not a lawyer and want to simulate a real UX
 */
export default function TOS() {
  const searchParams = useSearchParams();
    const referrer = searchParams.get("referrer");

    function canReturn() {
      switch (referrer) {
        case "login":
        case "register":
          return true;
        default:
          return false;
      }
    }

    const returnTo = () => {
        if (canReturn()) {
            return (
              <Link className="" href={`/${referrer}`}>
                <Button>Return to {referrer}
                </Button>
              </Link>
            );
        }
      };
  return (
    <main className="flex flex-col items-center gap-2 mx-4">
        <div className="flex flex-col gap-2">
      <h1 className="text-3xl font-bold">Terms of Service</h1>
        <h2 className="text-xl">Welcome to NU Munchies. Before you explore our offerings, it is important to understand the terms governing the use of NU Munchies. This serves to ensure a smooth and enjoyable experience for everyone involved.</h2>
        {returnTo()}
        </div>
        <Separator className="my-4" />
        <TooltipProvider>
      <Tooltip>
        <TooltipTrigger asChild>
      <ol className="list-decimal p-4 text-lg mx-4">
        <li>
          <p><strong>Agreement to Terms:</strong> By utilizing NU Munchies, you accept these terms. If you do not agree, you will not be able to use our service. Compliance with these terms is mandatory for all users.</p>
        </li>
        <li>
          <p><strong>Permitted Use:</strong> NU Munchies is intended for personal, non-commercial use. Misuse of our service for illegal activities or in ways that could bring legal repercussions to NU Munchies is prohibited.</p>
        </li>
        <li>
          <p><strong>User Content:</strong> Any content shared with NU Munchies may be used in connection with the services we provide. This does not transfer ownership; it merely allows us to display or use your content as part of our offerings.</p>
        </li>
        <li>
          <p><strong>Account Responsibility:</strong> Keep your account details confidential. You are responsible for all activities under your account.</p>
        </li>
        <li>
          <p><strong>Violations:</strong> Failure to adhere to these terms may result in termination of access to NU Munchies. We enforce these terms to maintain a safe and compliant community.</p>
        </li>
        <li>
          <p><strong>Limitation of Liability:</strong> NU Munchies and its operators are not liable for any direct or indirect damages arising from your use of the service. Our aim is to provide a reliable platform, but we cannot be held accountable for any incidents outside our control.</p>
        </li>
        <li>
          <p><strong>Jurisdiction:</strong> These terms are governed by the laws of the jurisdiction in which NU Munchies operates. Any disputes must be resolved according to these laws.</p>
        </li>
        <li>
          <p><strong>Term Changes:</strong> We reserve the right to modify these terms at any time. Continued use of NU Munchies after changes signifies acceptance of the new terms. Discontinue use if you do not agree with the changes.</p>
        </li>
        <li>
          <p><strong>Contact Us:</strong> Should you have any questions or need clarification on these terms, please do not hesitate to contact us. We are committed to providing assistance and ensuring your understanding of our terms.</p>
        </li>
      </ol>
      </TooltipTrigger>
        <TooltipContent>
          <p>This Terms Of Service was generated by ChatGPT and styled into a page</p>
        </TooltipContent>
      </Tooltip>
    </TooltipProvider>
    </main>
  );
}
