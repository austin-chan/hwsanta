//
//  GameState.h
//  HopingForAWish
//
//  Created by Austin Chan on 12/4/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface GameState : NSObject

@property NSMutableDictionary *storage;

+ (GameState *)sharedGameState;
- (void)load;

- (void)saveStage:(NSString *)stage;
- (NSString *)getStage;

- (void)setUserID:(NSString *)number;
- (NSString *)getUserID;

- (void)setSelectionChoices:(NSArray *)choices;
- (NSArray *)getSelectionChoices;


@end
