"use client";
import useUserSubsystem from "@/hooks/user-subsystem/use-user-subsystem";
import LoadingInPage from '../reusable/LoadingInPage';
import RedirectTo from "../reusable/RedirectTo";
import Verify from "../Verify";
import BannedScreen from "./BannedScreen";

export default function requireAuth(ChildComponents: any, pageNeedsAuth: boolean = true) {
    const RequireAuthComponent = (props: any) => {
        const { loading, logged, user, isIPAllowed} = useUserSubsystem();
        
        if(loading) {
            return (
            <div className="flex flex-col min-h-[85vh] justify-center align-center">
                <div className="mx-auto my-auto">
                    <LoadingInPage />
                </div>
            </div>
            );
        } else if(!loading && logged) {
            /**
             * Allowed has to be first as if the IP isnt allowed the user
             * info wont be sent by the server
             */
            if(user.banned) {
                return <BannedScreen />;
            }
            if(!isIPAllowed) {
                return <Verify type="ip_verification" />;
            } else if(!user.verified) {
                return <Verify type="email_verification" />;
            }
        }
        
        if(pageNeedsAuth && !logged && !loading) {
            return <RedirectTo to="/login" message={"This page requires you to be logged in"} />;
        } else if(!pageNeedsAuth && logged && !loading) {
            return <RedirectTo to="/profile" message={"This page requires you to be logged out"} />;
        }
        return <ChildComponents {...props} />;
    };

    RequireAuthComponent.displayName = `requireAuth(${ChildComponents.displayName || ChildComponents.name || 'Component'})`;

    return RequireAuthComponent;
}
