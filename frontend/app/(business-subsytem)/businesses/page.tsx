import { useBusinessApi } from "@/hooks/business-subsystem/use-business-api";
import { Suspense } from "react";
import { unstable_noStore as noStore } from "next/cache";

import Link from "next/link";
import { mainConfig } from "@/config/main";
import { Skeleton } from "@/components/ui/skeleton";

export interface BusinessResponse {
  id: string;
  name: string;
  description: string;
  email: string | undefined;
  address:
    | {
        address: string;
        city: string;
        postcode: string;
        country: string;
      }
    | undefined;
  phone: string | undefined;
}

// The data is fetched on the backend and streamed to the frontend - suspense is used to show a loading UI
export default async function BusinessesPage() {
  // this is needed to prevent next from statically generating the page
  noStore();
  return (
    <main>
      <div className="px-5 md:px-[10%] mt-4">
        <h1 className="text-3xl mb-3 font-bold">List of Businesses</h1>
        <p className="text-muted-foreground">
          Here you can find a list of businesses registered with NU Munchies
        </p>
        <hr className="my-5" />
        <Suspense fallback={LoadingUi()}>
          <BusinessesList />
        </Suspense>
      </div>
    </main>
  );
}

const BusinessesList = async () => {
  const businesses = await fetch(mainConfig.origin + "/business").then((res) =>
    res.json()
  );
  const { message } = businesses;

  return (
    <div className="flex flex-col gap-y-5">
      {message.map((business: BusinessResponse) => (
        <Link
          key={business.id}
          href={`/business/${business.id}`}
          className="group"
        >
          <h2 className="text-2xl font-bold mb-1 group-hover:underline">
            {business.name}
          </h2>
          <p className="text-muted-foreground">{business.description}</p>
        </Link>
      ))}
    </div>
  );
};

const LoadingUi = () => {
  return (
    <div>
      <Skeleton className="w-[280px] h-[40px] mb-2" />
      <Skeleton className="w-[500px] h-[25px]" />
      <div className="h-4" />
      <Skeleton className="w-[280px] h-[40px] mb-2" />
      <Skeleton className="w-[500px] h-[25px]" />
    </div>
  );
};
