import { registerFormSchema } from "@/app/(business-subsytem)/utils/register-formschema";
import { Endpoints } from "@/config/endpoints";
import { sendRequest } from "@/lib/send-request";
import { userAtom } from "@/stores/auth";
import { useAtom } from "jotai";
import { z } from "zod";

interface CreateBusinessRequest {
  name: string;
  description: string;
  address: string;
  city: string;
  postcode: string;
  country: string;
  phone?: string;
  email?: string;
}

type UserInput = z.infer<typeof registerFormSchema>;

export const useBusinessApi = () => {
  // insert user state
  const [user, setUser] = useAtom(userAtom);

  const createBusiness = async (data: UserInput) => {
    const requestBody: CreateBusinessRequest = {
      name: data.businessName,
      description: data.businessDescription,
      address: data.businessAddress,
      city: data.businessCity,
      postcode: data.businessPostcode,
      country: "United Kingdom",
      phone: data.businessPhoneNumber,
      email: data.businessEmail,
    };

    const res = await sendRequest<CreateBusinessRequest>(
      Endpoints.businessCreate,
      "POST",
      requestBody
    );

    return res;
  };

  return {
    createBusiness,
  };
};
