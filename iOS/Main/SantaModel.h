//
//  SantaModel.h
//  HopingForAWish
//
//  Created by Austin Chan on 11/26/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import <Foundation/Foundation.h>

@class LoginViewController;

@interface SantaModel : NSObject{
    
}

+ (SantaModel *)sharedSantaModel;
- (int)daysUntilSantageddon;

- (NSString *)checkMyRecipient:(NSString *)userId;
- (NSString *)checkMySanta:(NSString *)userId;
- (NSString *)checkMyName:(NSString *)userId;

+ (NSString *)getU;

- (void)loginRequestWithUsername:(NSString *)username andPassword:(NSString *)password forLoginView:(LoginViewController *)loginView;

@end
